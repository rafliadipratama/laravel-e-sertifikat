<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VerificationController extends Controller
{
    public function index(): View
    {
        return view('verification.index');
    }

    public function search(Request $request): RedirectResponse
    {
        $request->validate([
            'query' => 'required|string|max:255',
        ]);

        $query = trim($request->input('query'));

        // Check if query matches verification token or certificate number
        $certificate = Certificate::where('verification_token', $query)
            ->orWhere('certificate_number', $query)
            ->first();

        if (! $certificate) {
            return redirect()->route('verify.index')
                ->withInput()
                ->with('error', "Sertifikat dengan nomor atau kode '{$query}' tidak ditemukan dalam sistem database kami.");
        }

        return redirect()->route('verify.show', ['token' => $certificate->verification_token]);
    }

    public function show(string $token): View
    {
        $certificate = Certificate::with('event')
            ->where('verification_token', $token)
            ->orWhere('certificate_number', $token)
            ->first();

        if (! $certificate) {
            return view('verification.not-found', [
                'token' => $token,
            ]);
        }

        $qrCode = $certificate->getQrCode();

        return view('verification.show', [
            'certificate' => $certificate,
            'qrCode' => $qrCode,
        ]);
    }
}
