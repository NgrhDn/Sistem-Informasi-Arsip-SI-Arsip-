@extends('layouts.app')

@section('title', 'About')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6">About</h1>

    @php(\Carbon\Carbon::setLocale('id'))
    @php($tanggalSekarang = \Carbon\Carbon::now()->translatedFormat('d F Y'))

    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-md flex flex-col md:flex-row items-center md:items-center gap-10">
    <div class="relative group mt-2 md:mt-0">
            <div class="w-44 h-44 sm:w-48 sm:h-48 rounded-full ring-4 ring-indigo-200 overflow-hidden shadow-lg transition-transform duration-300 group-hover:scale-[1.02] bg-white">
                <img src="{{ asset('images/foto-profil.jpg') }}" alt="Foto" class="w-full h-full object-cover" loading="lazy">
            </div>
        </div>
        <div class="flex-1 w-full">
            <div class="divide-y divide-gray-200 border border-gray-100 rounded-lg overflow-hidden bg-gray-50">
                <div class="grid grid-cols-3 gap-2 px-4 py-3">
                    <span class="font-semibold text-gray-700 col-span-1">Nama</span>
                    <span class="col-span-2">: Danda Nugroho Hibatulloh</span>
                </div>
                <div class="grid grid-cols-3 gap-2 px-4 py-3">
                    <span class="font-semibold text-gray-700 col-span-1">Prodi</span>
                    <span class="col-span-2">: D3-MI PSDKU Kediri</span>
                </div>
                <div class="grid grid-cols-3 gap-2 px-4 py-3">
                    <span class="font-semibold text-gray-700 col-span-1">NIM</span>
                    <span class="col-span-2">: 2331730144</span>
                </div>
                <div class="grid grid-cols-3 gap-2 px-4 py-3">
                    <span class="font-semibold text-gray-700 col-span-1">Tanggal</span>
                    <span class="col-span-2">: {{ $tanggalSekarang }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

