@extends('layouts.app')

@section('title', 'Pusat Verifikasi Keaslian Sertifikat')

@section('content')
<div class="max-w-2xl mx-auto py-8 space-y-8">
    <div class="text-center space-y-3">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 mb-2">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
        </div>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Verifikasi Keaslian Sertifikat</h1>
        <p class="text-sm text-slate-500 max-w-md mx-auto">
            Masukkan Nomor Sertifikat resmi atau Kode Verifikasi untuk memeriksa keaslian dokumen yang diterbitkan.
        </p>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-10">
        <form action="{{ route('verify.search') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="query" class="block text-sm font-semibold text-slate-700 mb-2">
                    Nomor Sertifikat / Token Unik
                </label>
                <div class="relative">
                    <input
                        type="text"
                        id="query"
                        name="query"
                        required
                        value="{{ old('query') }}"
                        placeholder="Contoh: SERT/2026/0001 atau token QR..."
                        class="w-full pl-11 pr-4 py-3 border @error('query') border-rose-300 @else border-slate-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 font-mono"
                    >
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
                @error('query')
                    <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-xl text-sm transition shadow-sm flex items-center justify-center space-x-2"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Verifikasi Dokumen Sekarang</span>
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-400">
                Data yang ditampilkan ditarik langsung dari basis data resmi sistem e-sertifikat terakreditasi.
            </p>
        </div>
    </div>
</div>
@endsection
