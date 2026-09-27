<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class CertificateController extends Controller
{
    public function create(Event $event): View
    {
        $nextNumber = $event->generateNextCertificateNumber();
        return view('certificates.create', compact('event', 'nextNumber'));
    }

    public function store(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_email' => 'nullable|email|max:255',
            'role' => 'required|string|max:100',
            'description' => 'nullable|string',
            'certificate_number' => 'required|string|max:255|unique:certificates,certificate_number',
            'issue_date' => 'required|date',
        ]);

        $event->certificates()->create($validated);

        return redirect()->route('events.show', $event)
            ->with('success', 'Sertifikat berhasil ditambahkan.');
    }

    public function bulkCreate(Event $event): View
    {
        return view('certificates.bulk-create', compact('event'));
    }

    public function bulkStore(Request $request, Event $event): RedirectResponse
    {
        $request->validate([
            'participants_data' => 'nullable|string',
            'csv_file' => 'nullable|file|mimes:csv,txt|max:4096',
            'default_role' => 'required|string|max:100',
            'default_description' => 'nullable|string',
            'issue_date' => 'required|date',
        ]);

        $rows = [];

        // 1. Process uploaded CSV file if present
        if ($request->hasFile('csv_file')) {
            $path = $request->file('csv_file')->getRealPath();
            if (($handle = fopen($path, 'r')) !== false) {
                $isHeader = true;
                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    // Check if first line is a header
                    if ($isHeader) {
                        $isHeader = false;
                        $firstCol = strtolower(trim($data[0] ?? ''));
                        if (in_array($firstCol, ['nama', 'name', 'nama lengkap', 'recipient', 'peserta'])) {
                            continue;
                        }
                    }

                    $name = trim($data[0] ?? '');
                    if (!empty($name)) {
                        $email = isset($data[1]) && filter_var(trim($data[1]), FILTER_VALIDATE_EMAIL) ? trim($data[1]) : null;
                        $role = isset($data[2]) && !empty(trim($data[2])) ? trim($data[2]) : $request->input('default_role');
                        $rows[] = ['name' => $name, 'email' => $email, 'role' => $role];
                    }
                }
                fclose($handle);
            }
        }

        // 2. Process manual multiline textarea data if present
        if ($request->filled('participants_data')) {
            $lines = explode("\n", str_replace("\r", "", $request->input('participants_data')));
            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line)) {
                    continue;
                }

                $parts = preg_split('/[,;\t]/', $line);
                $name = trim($parts[0] ?? '');
                if (!empty($name)) {
                    $email = isset($parts[1]) && filter_var(trim($parts[1]), FILTER_VALIDATE_EMAIL) ? trim($parts[1]) : null;
                    $role = isset($parts[2]) && !empty(trim($parts[2])) ? trim($parts[2]) : $request->input('default_role');
                    $rows[] = ['name' => $name, 'email' => $email, 'role' => $role];
                }
            }
        }

        if (empty($rows)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Tidak ada data peserta valid yang ditemukan dari file CSV atau teks yang dimasukkan.');
        }

        $countCreated = 0;
        foreach ($rows as $item) {
            $certNumber = $event->generateNextCertificateNumber();

            $event->certificates()->create([
                'recipient_name' => $item['name'],
                'recipient_email' => $item['email'],
                'role' => $item['role'],
                'description' => $request->input('default_description'),
                'certificate_number' => $certNumber,
                'issue_date' => $request->input('issue_date'),
                'verification_token' => Str::random(40),
            ]);

            $countCreated++;
        }

        return redirect()->route('events.show', $event)
            ->with('success', "{$countCreated} sertifikat berhasil diterbitkan secara massal.");
    }

    public function showPdf(Certificate $certificate): Response
    {
        $certificate->load('event');
        $event = $certificate->event;
        $qrCode = $certificate->getQrCode();

        $pdf = Pdf::loadView('certificates.pdf', [
            'certificate' => $certificate,
            'qrCode' => $qrCode,
            'logoBase64' => $event->getLogoBase64(),
            'signatureBase64' => $event->getSignatureBase64(),
        ])->setPaper('a4', 'landscape');

        $fileName = Str::slug($certificate->recipient_name . '-' . $certificate->certificate_number) . '.pdf';

        return $pdf->stream($fileName);
    }

    public function downloadPdf(Certificate $certificate): Response
    {
        $certificate->load('event');
        $event = $certificate->event;
        $qrCode = $certificate->getQrCode();

        $pdf = Pdf::loadView('certificates.pdf', [
            'certificate' => $certificate,
            'qrCode' => $qrCode,
            'logoBase64' => $event->getLogoBase64(),
            'signatureBase64' => $event->getSignatureBase64(),
        ])->setPaper('a4', 'landscape');

        $fileName = Str::slug($certificate->recipient_name . '-' . $certificate->certificate_number) . '.pdf';

        return $pdf->download($fileName);
    }

    public function downloadZip(Event $event): BinaryFileResponse|RedirectResponse
    {
        $certificates = $event->certificates()->get();

        if ($certificates->isEmpty()) {
            return redirect()->route('events.show', $event)
                ->with('error', 'Belum ada sertifikat yang dapat diunduh pada acara ini.');
        }

        $zipFileName = Str::slug('sertifikat-' . $event->title) . '-' . date('Ymd-His') . '.zip';
        $zipFilePath = storage_path('app/temp-' . Str::random(16) . '.zip');

        $zip = new ZipArchive();
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return redirect()->route('events.show', $event)
                ->with('error', 'Gagal membuat berkas arsip ZIP.');
        }

        $logoBase64 = $event->getLogoBase64();
        $signatureBase64 = $event->getSignatureBase64();

        foreach ($certificates as $cert) {
            $qrCode = $cert->getQrCode();

            $pdf = Pdf::loadView('certificates.pdf', [
                'certificate' => $cert,
                'qrCode' => $qrCode,
                'logoBase64' => $logoBase64,
                'signatureBase64' => $signatureBase64,
            ])->setPaper('a4', 'landscape');

            $pdfName = Str::slug($cert->certificate_number . '-' . $cert->recipient_name) . '.pdf';
            $zip->addFromString($pdfName, $pdf->output());
        }

        $zip->close();

        return response()->download($zipFilePath, $zipFileName)->deleteFileAfterSend(true);
    }

    public function destroy(Certificate $certificate): RedirectResponse
    {
        $event = $certificate->event;
        $certificate->delete();

        return redirect()->route('events.show', $event)
            ->with('success', 'Sertifikat berhasil dihapus.');
    }
}
