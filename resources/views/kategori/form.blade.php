@extends('layouts.app')

{{-- Judul halaman akan berubah tergantung mode (Tambah atau Edit) --}}
@section('title', isset($kategori) ? 'Edit Kategori' : 'Tambah Kategori')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-2">Kategori Surat >> {{ isset($kategori) ? 'Edit' : 'Tambah' }}</h1>
    <p class="text-gray-600 mb-6">{{ isset($kategori) ? 'Edit data kategori yang sudah ada.' : 'Tambahkan data kategori baru.' }} Jika sudah selesai, jangan lupa untuk mengklik tombol "Simpan".</p>

    {{-- Menampilkan pesan error jika validasi gagal --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Oops! Terjadi kesalahan.</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="bg-white p-8 rounded-lg shadow-md">
        {{-- Formulir akan mengirim data ke route 'update' jika sedang mengedit, atau 'store' jika sedang menambah --}}
        <form action="{{ isset($kategori) ? route('kategori.update', $kategori->id_kategori) : route('kategori.store') }}" method="POST">
            @csrf
            {{-- Menambahkan method PUT spoofing untuk proses update --}}
            @if(isset($kategori))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4 items-center">
                <div class="md:col-span-1">
                    <label class="block text-gray-700 font-semibold">ID (Auto Increment)</label>
                </div>
                <div class="md:col-span-2">
                    <input type="text" class="border rounded-lg p-2 w-full bg-gray-100 cursor-not-allowed" value="{{ $kategori->id_kategori ?? 'Otomatis' }}" disabled>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4 items-center">
                <div class="md:col-span-1">
                    <label for="nama_kategori" class="block text-gray-700 font-semibold">Nama Kategori</label>
                </div>
                <div class="md:col-span-2">
                    <input type="text" name="nama_kategori" id="nama_kategori" class="border rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-indigo-400" value="{{ old('nama_kategori', $kategori->nama_kategori ?? '') }}" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 items-start">
                <div class="md:col-span-1">
                    <label for="keterangan" class="block text-gray-700 font-semibold">Keterangan</label>
                </div>
                <div class="md:col-span-2">
                    <textarea name="keterangan" id="keterangan" rows="4" class="border rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ old('keterangan', $kategori->keterangan ?? '') }}</textarea>
                </div>
            </div>

            <div class="flex items-center space-x-4 mt-8">
                <a href="{{ route('kategori.index') }}" class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-200">
                    &lt;&lt; Kembali
                </a>
                <button type="submit" class="bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-200">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

