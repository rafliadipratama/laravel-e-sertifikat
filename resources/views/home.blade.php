@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="space-y-10">
    <!-- Hero & Search Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-900 via-indigo-800 to-slate-900 text-white p-8 md:p-12 shadow-xl">
        <div class="relative z-10 max-w-3xl">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-500/20 text-indigo-200 border border-indigo-400/30 mb-4">
                Sistem E-Sertifikat Digital
            </span>
            <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight leading-tight">
                Penerbitan & Verifikasi Sertifikat Resmi Cepat dan Aman
            </h1>
            <p class="mt-4 text-base md:text-lg text-indigo-100/90 leading-relaxed">
                Kelola acara, buat sertifikat peserta secara satuan maupun massal, dan lakukan verifikasi keaslian dokumen dengan kode QR terintegrasi.
            </p>

            <!-- Quick Verification Search Form -->
            <form action="{{ route('verify.search') }}" method="POST" class="mt-8 bg-white/10 backdrop-blur-md p-2 rounded-2xl border border-white/20 flex flex-col sm:flex-row gap-2 max-w-xl">
                @csrf
                <input
                    type="text"
                    name="query"
                    required
                    placeholder="Masukkan Nomor Sertifikat atau Token Verifikasi..."
                    value="{{ old('query') }}"
                    class="flex-grow bg-white text-slate-900 placeholder-slate-400 px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400 text-sm font-medium"
                >
                <button
                    type="submit"
                    class="bg-indigo-500 hover:bg-indigo-400 text-white font-semibold px-6 py-3 rounded-xl text-sm transition flex items-center justify-center space-x-2 shrink-0 shadow-lg"
                >
                    <span>Cek Keaslian</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Total Acara / Kegiatan</p>
                <p class="text-3xl font-bold text-slate-900 mt-2">{{ $totalEvents }}</p>
                <a href="{{ route('events.index') }}" class="text-xs text-indigo-600 font-medium hover:underline mt-2 inline-block">
                    Lihat semua acara &rarr;
                </a>
            </div>
            <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Sertifikat Diterbitkan</p>
                <p class="text-3xl font-bold text-slate-900 mt-2">{{ $totalCertificates }}</p>
                <p class="text-xs text-emerald-600 font-medium mt-2">Terdaftar & Terverifikasi</p>
            </div>
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Aksi Cepat</p>
                <div class="flex items-center space-x-2 mt-3">
                    <a href="{{ route('events.create') }}" class="inline-flex items-center px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg shadow-sm transition">
                        + Buat Acara Baru
                    </a>
                </div>
            </div>
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Recent Data Grids -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Acara Terbaru -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-bold text-slate-900 text-base">Acara Terbaru</h2>
                <a href="{{ route('events.index') }}" class="text-xs text-indigo-600 hover:underline font-medium">Semua Acara</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentEvents as $event)
                    <div class="p-6 hover:bg-slate-50 transition flex items-center justify-between">
                        <div>
                            <a href="{{ route('events.show', $event) }}" class="font-semibold text-slate-900 hover:text-indigo-600">
                                {{ $event->title }}
                            </a>
                            <p class="text-xs text-slate-500 mt-1">
                                {{ $event->organizer }} &bull; {{ $event->event_date->format('d M Y') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                                {{ $event->certificates_count }} Peserta
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-sm text-slate-500">
                        Belum ada acara yang terdaftar. <a href="{{ route('events.create') }}" class="text-indigo-600 font-semibold hover:underline">Tambah Acara Pertama</a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Sertifikat Terbaru -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-bold text-slate-900 text-base">Sertifikat Terbaru Diterbitkan</h2>
                <a href="{{ route('events.index') }}" class="text-xs text-indigo-600 hover:underline font-medium">Kelola</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentCertificates as $cert)
                    <div class="p-6 hover:bg-slate-50 transition flex items-center justify-between">
                        <div>
                            <p class="font-semibold text-slate-900">{{ $cert->recipient_name }}</p>
                            <p class="text-xs text-slate-500 mt-1">
                                <span class="font-mono text-indigo-600">{{ $cert->certificate_number }}</span> &bull; {{ $cert->event->title }}
                            </p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('certificates.pdf.show', $cert) }}" target="_blank" class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-medium text-slate-700 hover:bg-slate-100 transition">
                                Unduh PDF
                            </a>
                            <a href="{{ route('verify.show', $cert->verification_token) }}" class="px-3 py-1.5 rounded-lg bg-indigo-50 text-xs font-medium text-indigo-600 hover:bg-indigo-100 transition">
                                Verifikasi
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-sm text-slate-500">
                        Belum ada sertifikat yang diterbitkan.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
