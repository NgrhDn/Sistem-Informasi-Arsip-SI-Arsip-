@extends('layouts.app')

@section('title', 'Edit Arsip Surat')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-2">Arsip Surat >> Edit</h1>
    <p class="text-gray-600 mb-6">Ubah data surat yang telah diarsipkan. Jika sudah selesai, jangan lupa untuk mengklik tombol "Simpan".</p>

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
        <form action="{{ route('arsip.update', $surat->id_surat) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4 items-center">
                <div class="md:col-span-1">
                    <label for="nomor_surat" class="block text-gray-700 font-semibold">Nomor Surat</label>
                </div>
                <div class="md:col-span-2">
                    <input type="text" name="nomor_surat" id="nomor_surat" class="border rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-indigo-400" value="{{ old('nomor_surat', $surat->nomor_surat) }}" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4 items-center">
                <div class="md:col-span-1">
                    <label for="id_kategori" class="block text-gray-700 font-semibold">Kategori</label>
                </div>
                <div class="md:col-span-2">
                    <select name="id_kategori" id="id_kategori" class="border rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                        <option value="" disabled>Pilih Kategori</option>
                        @foreach ($kategoriList as $kategori)
                            {{-- Pilih kategori yang sesuai dengan data surat saat ini --}}
                            <option value="{{ $kategori->id_kategori }}" {{ old('id_kategori', $surat->id_kategori) == $kategori->id_kategori ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4 items-center">
                <div class="md:col-span-1">
                    <label for="judul" class="block text-gray-700 font-semibold">Judul</label>
                </div>
                <div class="md:col-span-2">
                    <input type="text" name="judul" id="judul" class="border rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-indigo-400" value="{{ old('judul', $surat->judul) }}" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 items-start">
                <div class="md:col-span-1">
                    <label for="file_surat" class="block text-gray-700 font-semibold">Ganti File Surat (PDF)</label>
                </div>
                <div class="md:col-span-2">
                    <p class="text-sm text-gray-500 mb-2">File saat ini: 
                        <a href="{{ asset('storage/pdf/' . $surat->nama_file) }}" target="_blank" class="text-indigo-600 hover:underline">{{ $surat->nama_file }}</a>
                    </p>
                    <input type="file" name="file_surat" id="file_surat" class="border rounded-lg p-2 w-full" accept=".pdf">
                    <p class="text-xs text-gray-500 mt-1">*Kosongkan jika tidak ingin mengganti file.</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-4 mt-8">
                <a href="{{ route('arsip.index') }}" class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-200">
                    &lt;&lt; Kembali
                </a>
                <button type="submit" class="bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

