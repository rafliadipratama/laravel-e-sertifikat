@extends('layouts.app')

@section('title', 'Hasil Verifikasi: ' . $certificate->recipient_name)

@section('content')
<div class="max-w-2xl mx-auto py-6 space-y-6">
    <!-- Verification Status Banner -->
    <div class="bg-emerald-500 rounded-3xl p-6 sm:p-8 text-white shadow-lg text-center relative overflow-hidden">
        <div class="relative z-10 flex flex-col items-center">
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-3">
                <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <span class="text-xs uppercase tracking-widest font-semibold bg-emerald-600/60 px-3 py-1 rounded-full mb-1">
                Terverifikasi Valid
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Dokumen Asli & Terdaftar</h1>
            <p class="text-emerald-100 text-xs sm:text-sm mt-1 max-w-md">
                Sertifikat ini terdaftar secara sah dalam pangkalan data kami.
            </p>
        </div>
    </div>

    <!-- Details Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
        <div class="border-b border-slate-100 pb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Nomor Sertifikat</span>
                <p class="font-mono text-base font-bold text-slate-900">{{ $certificate->certificate_number }}</p>
            </div>
            <div class="text-left sm:text-right">
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Tanggal Diterbitkan</span>
                <p class="text-sm font-semibold text-slate-800">{{ $certificate->issue_date->format('d F Y') }}</p>
            </div>
        </div>

        <div class="space-y-4">
            <div>
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Nama Penerima</span>
                <p class="text-xl font-bold text-indigo-700 mt-0.5">{{ $certificate->recipient_name }}</p>
                @if($certificate->recipient_email)
                    <p class="text-xs text-slate-500">{{ $certificate->recipient_email }}</p>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <div>
                    <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Peran / Kategori</span>
                    <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $certificate->role }}</p>
                </div>
                <div>
                    <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Penyelenggara</span>
                    <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $certificate->event->organizer }}</p>
                </div>
            </div>

            <div class="pt-2">
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Kegiatan / Acara</span>
                <p class="text-sm font-bold text-slate-900 mt-0.5">{{ $certificate->event->title }}</p>
                <p class="text-xs text-slate-500 mt-0.5">
                    Dilaksanakan pada {{ $certificate->event->event_date->format('d F Y') }}
                    @if($certificate->event->location)
                        &bull; {{ $certificate->event->location }}
                    @endif
                </p>
            </div>

            @if($certificate->description)
                <div class="pt-2">
                    <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Keterangan Khusus</span>
                    <p class="text-xs text-slate-600 italic mt-0.5">{{ $certificate->description }}</p>
                </div>
            @endif

            <div class="pt-2">
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Penandatangan Resmi</span>
                <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $certificate->event->signer_name }}</p>
                <p class="text-xs text-slate-500">{{ $certificate->event->signer_position }}</p>
            </div>
        </div>

        <!-- QR Code & Download Box -->
        <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-6 bg-slate-50 p-4 rounded-2xl">
            <div class="flex items-center space-x-4">
                @if(isset($qrCode))
                    <img src="{{ $qrCode }}" alt="QR Verifikasi" class="w-16 h-16 bg-white p-1 rounded-lg border border-slate-200">
                @endif
                <div class="text-xs text-slate-500">
                    <p class="font-semibold text-slate-800">Pindai QR Dokumen</p>
                    <p>Memuat token verifikasi digital resmi.</p>
                </div>
            </div>

            <div class="flex items-center space-x-2 w-full sm:w-auto">
                <a href="{{ route('certificates.pdf.show', $certificate) }}" target="_blank" class="flex-1 sm:flex-none text-center px-4 py-2.5 border border-slate-300 text-slate-700 hover:bg-white rounded-xl text-xs font-semibold transition">
                    Lihat PDF
                </a>
                <a href="{{ route('certificates.pdf.download', $certificate) }}" class="flex-1 sm:flex-none text-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold transition shadow-sm">
                    Unduh PDF
                </a>
            </div>
        </div>

        <div class="text-center pt-2">
            <a href="{{ route('verify.index') }}" class="text-xs text-indigo-600 hover:underline font-medium">
                &larr; Cek Sertifikat Lainnya
            </a>
        </div>
    </div>
</div>
@endsection
