@extends('layouts.app')

@section('title', 'Lihat Arsip Surat')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-2">Arsip Surat >> Lihat</h1>
    <p class="text-gray-600 mb-6">Berikut ini adalah detail dari surat yang telah diarsipkan.</p>

    <div class="bg-white p-8 rounded-lg shadow-md">
        <table class="w-full mb-6">
            <tbody>
                <tr class="border-b">
                    <td class="py-2 font-semibold pr-4 w-1/4">Nomor Surat</td>
                    <td>: {{ $surat->nomor_surat }}</td>
                </tr>
                 <tr class="border-b">
                    <td class="py-2 font-semibold pr-4">Kategori</td>
                    <td>: {{ $surat->kategori->nama_kategori }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 font-semibold pr-4">Judul</td>
                    <td>: {{ $surat->judul }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-semibold pr-4">Waktu Unggah</td>
                    <td>: {{ $surat->created_at?->timezone('Asia/Jakarta')->translatedFormat('d F Y H:i:s') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="border-2 rounded-lg p-2">
            @php
                use Illuminate\Support\Facades\Storage;
                $relative = 'pdf/' . $surat->nama_file;
                $fileExists = $surat->nama_file && Storage::disk('public')->exists($relative);
            @endphp
            @if($fileExists)
                <div class="w-full h-[500px]">
                    <iframe src="{{ route('arsip.preview',$surat->id_surat) }}?v={{ $surat->updated_at?->timestamp }}" class="w-full h-full" title="Pratinjau PDF" frameborder="0"></iframe>
                </div>
            @else
                <div class="text-center py-10 text-gray-500">
                    <p>File PDF tidak ditemukan. Pastikan sudah menjalankan perintah <code>php artisan storage:link</code> dan file tersimpan di <code>storage/app/public/pdf</code>.</p>
                </div>
            @endif
        </div>

        <div class="flex items-center space-x-4 mt-8">
            <a href="{{ route('arsip.index') }}" class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-200">
                &lt;&lt; Kembali
            </a>
            <a href="{{ route('arsip.download', $surat->id_surat) }}" class="bg-green-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-700 transition duration-200" download>
                Unduh PDF
            </a>
             <a href="{{ route('arsip.edit', $surat->id_surat) }}" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-200">
                Edit/Ganti File
            </a>
        </div>
    </div>
</div>
@endsection

