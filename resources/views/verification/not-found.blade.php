@extends('layouts.app')

@section('title', 'Sertifikat Tidak Ditemukan')

@section('content')
<div class="max-w-xl mx-auto py-12 text-center space-y-6">
    <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-rose-50 text-rose-600 mb-2">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
    </div>

    <div class="space-y-2">
        <span class="text-xs uppercase tracking-widest font-semibold bg-rose-100 text-rose-700 px-3 py-1 rounded-full">
            Tidak Terverifikasi
        </span>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
            Sertifikat Tidak Ditemukan
        </h1>
        <p class="text-sm text-slate-500 max-w-md mx-auto">
            Dokumen dengan kode <code class="bg-slate-100 px-2 py-0.5 rounded text-rose-600 font-mono text-xs">{{ $token }}</code> tidak terdaftar di sistem.
        </p>
    </div>

    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 text-xs text-amber-800 text-left max-w-md mx-auto space-y-1">
        <p class="font-semibold">Kemungkinan penyebab:</p>
        <ul class="list-disc pl-5 space-y-0.5 text-amber-700">
            <li>Terdapat kesalahan pengetikan nomor sertifikat.</li>
            <li>Sertifikat belum resmi diterbitkan atau telah dicabut.</li>
            <li>QR Code atau tautan rusak.</li>
        </ul>
    </div>

    <div class="pt-4 flex items-center justify-center space-x-3">
        <a href="{{ route('verify.index') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition">
            Coba Periksa Kembali
        </a>
        <a href="{{ route('home') }}" class="px-5 py-2.5 border border-slate-200 text-slate-700 hover:bg-slate-50 rounded-xl text-sm font-medium transition">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
