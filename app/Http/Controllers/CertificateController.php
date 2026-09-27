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
        $validated = $request->validate([
            'participants_data' => 'required|string',
            'default_role' => 'required|string|max:100',
            'default_description' => 'nullable|string',
            'issue_date' => 'required|date',
        ]);

        $lines = explode("\n", str_replace("\r", "", $validated['participants_data']));
        $countCreated = 0;

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }

            // Supports format: "Nama Lengkap, email@example.com, Role" or tab-delimited or just "Nama Lengkap"
            $parts = preg_split('/[,;\t]/', $line);
            $name = trim($parts[0] ?? '');
            $email = isset($parts[1]) && filter_var(trim($parts[1]), FILTER_VALIDATE_EMAIL) ? trim($parts[1]) : null;
            $role = isset($parts[2]) && !empty(trim($parts[2])) ? trim($parts[2]) : $validated['default_role'];

            if (empty($name)) {
                continue;
            }

            $certNumber = $event->generateNextCertificateNumber();

            $event->certificates()->create([
                'recipient_name' => $name,
                'recipient_email' => $email,
                'role' => $role,
                'description' => $validated['default_description'],
                'certificate_number' => $certNumber,
                'issue_date' => $validated['issue_date'],
                'verification_token' => Str::random(40),
            ]);

            $countCreated++;
        }

        return redirect()->route('events.show', $event)
            ->with('success', "{$countCreated} sertifikat berhasil dibuat sekaligus.");
    }

    public function showPdf(Certificate $certificate): Response
    {
        $certificate->load('event');
        $qrCode = $certificate->getQrCode();

        $pdf = Pdf::loadView('certificates.pdf', [
            'certificate' => $certificate,
            'qrCode' => $qrCode,
        ])->setPaper('a4', 'landscape');

        $fileName = Str::slug($certificate->recipient_name . '-' . $certificate->certificate_number) . '.pdf';

        return $pdf->stream($fileName);
    }

    public function downloadPdf(Certificate $certificate): Response
    {
        $certificate->load('event');
        $qrCode = $certificate->getQrCode();

        $pdf = Pdf::loadView('certificates.pdf', [
            'certificate' => $certificate,
            'qrCode' => $qrCode,
        ])->setPaper('a4', 'landscape');

        $fileName = Str::slug($certificate->recipient_name . '-' . $certificate->certificate_number) . '.pdf';

        return $pdf->download($fileName);
    }

    public function destroy(Certificate $certificate): RedirectResponse
    {
        $event = $certificate->event;
        $certificate->delete();

        return redirect()->route('events.show', $event)
            ->with('success', 'Sertifikat berhasil dihapus.');
    }
}
