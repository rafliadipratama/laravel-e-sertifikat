@extends('layouts.app')

@section('title', 'Tambah Sertifikat Peserta')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center space-x-2 text-sm text-slate-500">
        <a href="{{ route('events.index') }}" class="hover:text-indigo-600">Acara</a>
        <span>/</span>
        <a href="{{ route('events.show', $event) }}" class="hover:text-indigo-600">{{ $event->title }}</a>
        <span>/</span>
        <span class="text-slate-800 font-medium">Tambah Peserta</span>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <div class="border-b border-slate-100 pb-4">
            <h1 class="text-xl font-bold text-slate-900">
                Penerbitan Sertifikat Peserta
            </h1>
            <p class="text-xs text-slate-500 mt-1">Acara: <strong class="text-slate-700">{{ $event->title }}</strong></p>
        </div>

        <form action="{{ route('certificates.store', $event) }}" method="POST" class="mt-6 space-y-6">
            @csrf

            <div>
                <label for="certificate_number" class="block text-sm font-semibold text-slate-700 mb-1">
                    Nomor Sertifikat <span class="text-rose-500">*</span>
                </label>
                <input
                    type="text"
                    id="certificate_number"
                    name="certificate_number"
                    required
                    value="{{ old('certificate_number', $nextNumber) }}"
                    class="w-full px-4 py-2.5 font-mono border @error('certificate_number') border-rose-300 @else border-slate-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                <p class="text-xs text-slate-400 mt-1">Nomor otomatis terisi sesuai urutan prefix acara.</p>
                @error('certificate_number')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="recipient_name" class="block text-sm font-semibold text-slate-700 mb-1">
                    Nama Lengkap Penerima <span class="text-rose-500">*</span>
                </label>
                <input
                    type="text"
                    id="recipient_name"
                    name="recipient_name"
                    required
                    value="{{ old('recipient_name') }}"
                    placeholder="Contoh: Muhammad Rafli Adi Pratama, S.Kom"
                    class="w-full px-4 py-2.5 border @error('recipient_name') border-rose-300 @else border-slate-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                @error('recipient_name')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="recipient_email" class="block text-sm font-semibold text-slate-700 mb-1">
                        Email Penerima (Opsional)
                    </label>
                    <input
                        type="email"
                        id="recipient_email"
                        name="recipient_email"
                        value="{{ old('recipient_email') }}"
                        placeholder="peserta@example.com"
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                </div>

                <div>
                    <label for="role" class="block text-sm font-semibold text-slate-700 mb-1">
                        Peran / Status <span class="text-rose-500">*</span>
                    </label>
                    <select
                        id="role"
                        name="role"
                        required
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white"
                    >
                        <option value="Peserta" {{ old('role') == 'Peserta' ? 'selected' : '' }}>Peserta</option>
                        <option value="Narasumber" {{ old('role') == 'Narasumber' ? 'selected' : '' }}>Narasumber / Pembicara</option>
                        <option value="Moderator" {{ old('role') == 'Moderator' ? 'selected' : '' }}>Moderator</option>
                        <option value="Panitia" {{ old('role') == 'Panitia' ? 'selected' : '' }}>Panitia Penyelenggara</option>
                        <option value="Juara 1" {{ old('role') == 'Juara 1' ? 'selected' : '' }}>Juara 1</option>
                        <option value="Juara 2" {{ old('role') == 'Juara 2' ? 'selected' : '' }}>Juara 2</option>
                        <option value="Juara 3" {{ old('role') == 'Juara 3' ? 'selected' : '' }}>Juara 3</option>
                    </select>
                </div>
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

            <div>
                <label for="description" class="block text-sm font-semibold text-slate-700 mb-1">
                    Keterangan Tambahan / Penghargaan (Opsional)
                </label>
                <textarea
                    id="description"
                    name="description"
                    rows="2"
                    placeholder="Kosongkan jika menggunakan keterangan standar acara..."
                    class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >{{ old('description') }}</textarea>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-slate-100">
                <a href="{{ route('events.show', $event) }}" class="px-5 py-2.5 border border-slate-200 text-slate-700 font-medium rounded-xl text-sm hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-sm shadow-sm transition">
                    Terbitkan Sertifikat
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
