@extends('layouts.app')

@section('title', 'Edit Acara')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center space-x-2 text-sm text-slate-500">
        <a href="{{ route('events.index') }}" class="hover:text-indigo-600">Acara</a>
        <span>/</span>
        <a href="{{ route('events.show', $event) }}" class="hover:text-indigo-600">{{ $event->title }}</a>
        <span>/</span>
        <span class="text-slate-800 font-medium">Edit</span>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <h1 class="text-xl font-bold text-slate-900 border-b border-slate-100 pb-4">
            Edit Data Acara
        </h1>

        <form action="{{ route('events.update', $event) }}" method="POST" class="mt-6 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-sm font-semibold text-slate-700 mb-1">
                    Nama Kegiatan / Judul Acara <span class="text-rose-500">*</span>
                </label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    required
                    value="{{ old('title', $event->title) }}"
                    class="w-full px-4 py-2.5 border @error('title') border-rose-300 @else border-slate-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                @error('title')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="organizer" class="block text-sm font-semibold text-slate-700 mb-1">
                        Penyelenggara / Instansi <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="organizer"
                        name="organizer"
                        required
                        value="{{ old('organizer', $event->organizer) }}"
                        class="w-full px-4 py-2.5 border @error('organizer') border-rose-300 @else border-slate-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                    @error('organizer')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="event_date" class="block text-sm font-semibold text-slate-700 mb-1">
                        Tanggal Pelaksanaan <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="date"
                        id="event_date"
                        name="event_date"
                        required
                        value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}"
                        class="w-full px-4 py-2.5 border @error('event_date') border-rose-300 @else border-slate-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                    @error('event_date')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="location" class="block text-sm font-semibold text-slate-700 mb-1">
                        Lokasi / Platform
                    </label>
                    <input
                        type="text"
                        id="location"
                        name="location"
                        value="{{ old('location', $event->location) }}"
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                </div>

                <div>
                    <label for="certificate_prefix" class="block text-sm font-semibold text-slate-700 mb-1">
                        Awalan Nomor Sertifikat <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="certificate_prefix"
                        name="certificate_prefix"
                        required
                        value="{{ old('certificate_prefix', $event->certificate_prefix) }}"
                        class="w-full px-4 py-2.5 border @error('certificate_prefix') border-rose-300 @else border-slate-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                    @error('certificate_prefix')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-semibold text-slate-700 mb-1">
                    Deskripsi / Keterangan Acara
                </label>
                <textarea
                    id="description"
                    name="description"
                    rows="3"
                    class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="pt-4 border-t border-slate-100">
                <h3 class="font-semibold text-slate-800 text-sm mb-4">Informasi Penandatangan Sertifikat</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="signer_name" class="block text-sm font-semibold text-slate-700 mb-1">
                            Nama Penandatangan <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="signer_name"
                            name="signer_name"
                            required
                            value="{{ old('signer_name', $event->signer_name) }}"
                            class="w-full px-4 py-2.5 border @error('signer_name') border-rose-300 @else border-slate-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                        @error('signer_name')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="signer_position" class="block text-sm font-semibold text-slate-700 mb-1">
                            Jabatan Penandatangan <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="signer_position"
                            name="signer_position"
                            required
                            value="{{ old('signer_position', $event->signer_position) }}"
                            class="w-full px-4 py-2.5 border @error('signer_position') border-rose-300 @else border-slate-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                        @error('signer_position')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-slate-100">
                <a href="{{ route('events.show', $event) }}" class="px-5 py-2.5 border border-slate-200 text-slate-700 font-medium rounded-xl text-sm hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-sm shadow-sm transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
