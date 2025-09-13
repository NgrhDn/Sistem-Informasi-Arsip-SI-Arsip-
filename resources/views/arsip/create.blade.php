@extends('layouts.app')

@section('title', 'Unggah Arsip Surat')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-2">Arsip Surat >> Unggah</h1>
    <p class="text-gray-600 mb-6">Unggah surat yang telah terbit pada form ini untuk diarsipkan.</p>
    <p class="text-gray-600 mb-6"><span class="font-bold">Catatan:</span> Gunakan file berformat PDF</p>
    
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Oops!</strong>
            <span class="block sm:inline">Terjadi beberapa kesalahan:</span>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-8 rounded-lg shadow-md">
        <form action="{{ route('arsip.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                <div class="md:col-span-1">
                    <label for="nomor_surat" class="block text-gray-700 font-semibold mb-2">Nomor Surat</label>
                </div>
                <div class="md:col-span-2">
                    <input type="text" name="nomor_surat" id="nomor_surat" class="border rounded-lg p-2 w-full" value="{{ old('nomor_surat') }}" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                 <div class="md:col-span-1">
                    <label for="id_kategori" class="block text-gray-700 font-semibold mb-2">Kategori</label>
                </div>
                <div class="md:col-span-2">
                    <select name="id_kategori" id="id_kategori" class="border rounded-lg p-2 w-full" required>
                        @foreach($kategoriList as $kategori)
                            <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

             <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                 <div class="md:col-span-1">
                    <label for="judul" class="block text-gray-700 font-semibold mb-2">Judul</label>
                </div>
                <div class="md:col-span-2">
                    <input type="text" name="judul" id="judul" class="border rounded-lg p-2 w-full" value="{{ old('judul') }}" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="md:col-span-1">
                    <label for="file_surat" class="block text-gray-700 font-semibold mb-2">File Surat (PDF)</label>
                </div>
                <div class="md:col-span-2">
                    <input type="file" name="file_surat" id="file_surat" class="border rounded-lg p-2 w-full" accept=".pdf" required>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <a href="{{ route('arsip.index') }}" class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-lg hover:bg-gray-300">
                    &lt;&lt; Kembali
                </a>
                <button type="submit" class="bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
