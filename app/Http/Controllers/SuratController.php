<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SuratController extends Controller
{
    /**Tampilan halaman utama dengan daftar surat yang diarsipkan.*/
    public function index(Request $request)
    {
        $query = Surat::with('kategori');

        // Pencarian sesuai requirement: hanya berdasarkan judul surat
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where('judul', 'LIKE', "%$term%");
        }

    // Hapus paginasi: ambil semua data (hati-hati jika data besar)
    $suratList = $query->orderBy('created_at', 'desc')->get();
        return view('arsip.index', compact('suratList'));
    }

    /**Menampilkan form untuk membuat arsip surat baru.*/
    public function create()
    {
        $kategoriList = Kategori::all();
        return view('arsip.create', compact('kategoriList'));
    }

    /**Menyimpan data arsip surat baru ke database.*/
    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'judul' => 'required|string|max:255',
            'file_surat' => 'required|file|mimes:pdf|max:9048',
        ]);

        if ($request->query('dbg') == '1') {
            return dd([
                'hasFile' => $request->hasFile('file_surat'),
                'errorCode' => $request->file('file_surat')?->getError(),
                'originalName' => $request->file('file_surat')?->getClientOriginalName(),
                'mime' => $request->file('file_surat')?->getMimeType(),
                'extGuess' => $request->file('file_surat')?->guessExtension(),
                'sizeBytes' => $request->file('file_surat')?->getSize(),
                'php_upload_max_filesize' => ini_get('upload_max_filesize'),
                'php_post_max_size' => ini_get('post_max_size'),
            ]);
        }

        
        $file = $request->file('file_surat');
    $original = $file->getClientOriginalName();
    $sanitizedBase = preg_replace('/[^A-Za-z0-9._-]/', '_', $original);
    $fileName = time() . '_' . $sanitizedBase;
       
        if (!Storage::disk('public')->exists('pdf')) {
            Storage::disk('public')->makeDirectory('pdf');
        }
        $stored = Storage::disk('public')->putFileAs('pdf', $file, $fileName);
        Log::info('SURAT UPLOAD', [
            'stored' => (bool)$stored,
            'path' => $stored,
            'exists' => Storage::disk('public')->exists('pdf/'.$fileName),
            'original' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
        ]);
        if (!$stored) {
            return back()->withErrors(['file_surat' => 'Gagal menyimpan file ke storage/public. Periksa izin folder.']);
        }

        Surat::create([
            'nomor_surat' => $request->nomor_surat,
            'id_kategori' => $request->id_kategori,
            'judul' => $request->judul,
            'nama_file' => $fileName,
        ]);

    return redirect()->route('arsip.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Menampilkan detail dari sebuah surat.
     */
    public function show($id)
    {
        $surat = Surat::with('kategori')->findOrFail($id);
        return view('arsip.show', compact('surat'));
    }
    
    /**
     * Menampilkan form untuk mengedit data surat.
     */
    public function edit($id)
    {
        $surat = Surat::findOrFail($id);
        $kategoriList = Kategori::all();
        return view('arsip.edit', compact('surat', 'kategoriList'));
    }

    /**
     * Mengupdate data surat di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'judul' => 'required|string|max:255',
            'file_surat' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $surat = Surat::findOrFail($id);

        $fileName = $surat->nama_file;
    if ($request->hasFile('file_surat')) {
           
            if ($surat->nama_file && Storage::disk('public')->exists('pdf/'.$surat->nama_file)) {
                Storage::disk('public')->delete('pdf/'.$surat->nama_file);
            }
            $file = $request->file('file_surat');
            $original = $file->getClientOriginalName();
            $sanitizedBase = preg_replace('/[^A-Za-z0-9._-]/', '_', $original);
            $fileName = time() . '_' . $sanitizedBase;
            if (!Storage::disk('public')->exists('pdf')) {
                Storage::disk('public')->makeDirectory('pdf');
            }
            $stored = Storage::disk('public')->putFileAs('pdf', $file, $fileName);
            if (!$stored) {
                return back()->withErrors(['file_surat' => 'Gagal menyimpan file baru.']);
            }
        }

        $surat->update([
            'nomor_surat' => $request->nomor_surat,
            'id_kategori' => $request->id_kategori,
            'judul' => $request->judul,
            'nama_file' => $fileName,
        ]);

        return redirect()->route('arsip.index')->with('success', 'Data surat berhasil diperbarui!');
    }


    /**
     * Menghapus data surat dari database.
     */
    public function destroy($id)
    {
        $surat = Surat::findOrFail($id);
        
        // Hapus file dari storage
        Storage::delete('public/pdf/' . $surat->nama_file);
        
        $surat->delete();

        return redirect()->route('arsip.index')->with('success', 'Surat berhasil dihapus!');
    }
    
    /**
     * Mengunduh file surat.
     */
    public function download($id)
    {
        $surat = Surat::findOrFail($id);
        $path = 'pdf/' . $surat->nama_file;
        if (Storage::disk('public')->exists($path)) {
            return response()->download(storage_path('app/public/'.$path));
        }
        return redirect()->back()->with('error', 'File tidak ditemukan di storage/public/pdf.');
    }


    public function preview($id)
    {
        $surat = Surat::findOrFail($id);
        $path = 'pdf/' . $surat->nama_file;
        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'File tidak ditemukan');
        }
        $fullPath = storage_path('app/public/' . $path);
        $mime = 'application/pdf';
        return response()->make(file_get_contents($fullPath), 200, [
            'Content-Type' => $mime,
            'Cache-Control' => 'no-store, max-age=0'
        ]);
    }
}
