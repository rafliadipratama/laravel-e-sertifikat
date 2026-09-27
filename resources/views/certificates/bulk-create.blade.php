@extends('layouts.app')

@section('title', 'Tambah Banyak Peserta Sekaligus')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center space-x-2 text-sm text-slate-500">
        <a href="{{ route('events.index') }}" class="hover:text-indigo-600">Acara</a>
        <span>/</span>
        <a href="{{ route('events.show', $event) }}" class="hover:text-indigo-600">{{ $event->title }}</a>
        <span>/</span>
        <span class="text-slate-800 font-medium">Tambah Massal</span>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <div class="border-b border-slate-100 pb-4">
            <h1 class="text-xl font-bold text-slate-900">
                Penerbitan Sertifikat Massal (Bulk / Import)
            </h1>
            <p class="text-xs text-slate-500 mt-1">Acara: <strong class="text-slate-700">{{ $event->title }}</strong></p>
        </div>

        <form action="{{ route('certificates.bulk.store', $event) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="default_role" class="block text-sm font-semibold text-slate-700 mb-1">
                        Peran Default <span class="text-rose-500">*</span>
                    </label>
                    <select
                        id="default_role"
                        name="default_role"
                        required
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white"
                    >
                        <option value="Peserta" selected>Peserta</option>
                        <option value="Narasumber">Narasumber</option>
                        <option value="Moderator">Moderator</option>
                        <option value="Panitia">Panitia</option>
                    </select>
                </div>

                <div>
                    <label for="issue_date" class="block text-sm font-semibold text-slate-700 mb-1">
                        Tanggal Terbit Sertifikat <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="date"
                        id="issue_date"
                        name="issue_date"
                        required
                        value="{{ old('issue_date', $event->event_date->format('Y-m-d')) }}"
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                </div>
            </div>

            <!-- Option 1: File CSV Upload -->
            <div class="bg-indigo-50/50 border border-indigo-100 rounded-2xl p-5 space-y-2">
                <label for="csv_file" class="block text-sm font-bold text-slate-800">
                    Opsi 1: Upload Berkas Spreadsheet (.CSV)
                </label>
                <p class="text-xs text-slate-500">
                    Dapat langsung mengekspor daftar hadir dari Google Spreadsheet atau Microsoft Excel ke format <code class="font-mono bg-white px-1 py-0.5 rounded border border-indigo-200">.csv</code> (Kolom: Nama, Email, Peran).
                </p>
                <input
                    type="file"
                    id="csv_file"
                    name="csv_file"
                    accept=".csv,text/csv"
                    class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 border border-slate-200 rounded-xl bg-white"
                >
                @error('csv_file')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Option 2: Copy-Paste Textarea -->
            <div class="space-y-2">
                <label for="participants_data" class="block text-sm font-bold text-slate-800">
                    Opsi 2: Salin-Tempel Teks (1 baris per nama)
                </label>
                <p class="text-xs text-slate-500">
                    Format: <code class="bg-slate-100 px-1 py-0.5 rounded text-indigo-700">Nama Lengkap</code> atau <code class="bg-slate-100 px-1 py-0.5 rounded text-indigo-700">Nama Lengkap, email@example.com</code> atau <code class="bg-slate-100 px-1 py-0.5 rounded text-indigo-700">Nama Lengkap, email, Peran</code>
                </p>
                <textarea
                    id="participants_data"
                    name="participants_data"
                    rows="6"
                    placeholder="Budi Setiawan&#10;Siti Rahmawati, siti@example.com&#10;Ahmad Fauzi, ahmad@example.com, Narasumber"
                    class="w-full font-mono text-sm px-4 py-3 border @error('participants_data') border-rose-300 @else border-slate-200 @enderror rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >{{ old('participants_data') }}</textarea>
                @error('participants_data')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="default_description" class="block text-sm font-semibold text-slate-700 mb-1">
                    Keterangan Tambahan Seragam (Opsional)
                </label>
                <textarea
                    id="default_description"
                    name="default_description"
                    rows="2"
                    placeholder="Contoh: Telah menyelesaikan seluruh rangkaian sesi pelatihan dengan nilai memuaskan."
                    class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >{{ old('default_description') }}</textarea>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-slate-100">
                <a href="{{ route('events.show', $event) }}" class="px-5 py-2.5 border border-slate-200 text-slate-700 font-medium rounded-xl text-sm hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-xl text-sm shadow-sm transition">
                    Proses & Terbitkan Semua Sertifikat
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
