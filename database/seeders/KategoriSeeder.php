<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            ['nama_kategori' => 'Undangan', 'keterangan' => 'Surat undangan resmi'],
            ['nama_kategori' => 'Pengumuman', 'keterangan' => 'Surat pengumuman'],
            ['nama_kategori' => 'Nota Dinas', 'keterangan' => 'Nota dinas internal'],
            ['nama_kategori' => 'Pemberitahuan', 'keterangan' => 'Surat pemberitahuan'],
        ];

        foreach ($defaults as $row) {
            Kategori::firstOrCreate(['nama_kategori' => $row['nama_kategori']], $row);
        }
    }
}
