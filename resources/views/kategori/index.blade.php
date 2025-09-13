@extends('layouts.app')

@section('title', 'Kategori Surat')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-2">Kategori Surat</h1>
    <p class="text-gray-600 mb-6">Berikut ini adalah kategori yang bisa digunakan untuk melabeli surat. <br>Klik "Tambah" pada kolom aksi untuk menambahkan kategori baru.</p>

    {{-- Notifikasi kini menggunakan toast global --}}

    <div class="bg-white p-6 rounded-lg shadow-md">
        {{-- Toolbar: Search + Tambah --}}
        <div class="mb-4">
            <form action="{{ route('kategori.index') }}" method="GET" class="flex items-center">
                <label for="search" class="mr-2 font-semibold text-gray-700 whitespace-nowrap">Cari kategori:</label>
                <input type="text" name="search" id="search" class="border rounded-lg p-2 flex-grow" placeholder="ID / Nama / Keterangan" value="{{ request('search') }}">
                <button type="submit" class="ml-2 bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700">Cari</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">ID Kategori</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Nama Kategori</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Keterangan</th>
                        <th class="text-center py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                     @forelse ($kategoriList as $kategori)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $kategori->id_kategori }}</td>
                            <td class="py-3 px-4">{{ $kategori->nama_kategori }}</td>
                            <td class="py-3 px-4">{{ $kategori->keterangan }}</td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('kategori.edit', $kategori->id_kategori) }}" class="bg-blue-500 text-white font-bold py-1 px-3 rounded-lg hover:bg-blue-600 text-sm">Edit</a>
                                    
                                    {{-- Tombol Hapus dengan Konfirmasi JS --}}
                                    <form id="delete-form-kategori-{{ $kategori->id_kategori }}" action="{{ route('kategori.destroy', $kategori->id_kategori) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" data-delete-trigger="delete-form-kategori-{{ $kategori->id_kategori }}" class="bg-red-500 text-white font-bold py-1 px-3 rounded-lg hover:bg-red-600 text-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">Tidak ada data kategori yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
    
         <div class="mt-4">
            {{ $kategoriList->appends(request()->query())->links() }}
        </div>
    </div>
    
    <a href="{{ route('kategori.create') }}" class="mt-6 inline-block bg-green-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-700">
        [+] Tambah Kategori
    </a>
</div>
@endsection

@push('styles')
<style>
/* Floating confirm dialog (shared style) */
.confirm-overlay{position:fixed;inset:0;display:none;align-items:flex-start;justify-content:center;padding-top:120px;background:rgba(0,0,0,.25);backdrop-filter:blur(2px);z-index:80;font-family:inherit}
.confirm-box{background:#fff;min-width:320px;max-width:440px;border-radius:16px;box-shadow:0 12px 40px -8px rgba(0,0,0,.35),0 0 0 1px rgba(0,0,0,.05);padding:26px 28px 24px;animation:fadeSlide .22s cubic-bezier(.22,.8,.36,1);position:relative}
@keyframes fadeSlide{from{opacity:0;transform:translateY(-14px) scale(.96)}to{opacity:1;transform:translateY(0) scale(1)}}
.confirm-title{font-size:17px;font-weight:600;margin:0 0 6px;text-align:left;display:flex;align-items:center;gap:10px}
.confirm-title:before{content:"";width:10px;height:10px;border-radius:50%;background:#dc2626;box-shadow:0 0 0 4px rgba(220,38,38,.25)}
.confirm-message{font-size:14px;color:#374151;margin:0 0 20px;text-align:left;line-height:1.5}
.confirm-actions{display:flex;gap:10px;justify-content:flex-end}
.confirm-btn{padding:10px 16px;font-size:14px;font-weight:600;border-radius:10px;cursor:pointer;transition:.18s;border:1px solid transparent;display:inline-flex;align-items:center;justify-content:center;min-width:90px}
.confirm-btn.cancel{background:#f3f4f6;color:#374151;border-color:#e5e7eb}
.confirm-btn.cancel:hover{background:#e5e7eb}
.confirm-btn.ok{background:#dc2626;color:#fff}
.confirm-btn.ok:hover{background:#b91c1c}
.confirm-close{position:absolute;top:10px;right:10px;background:transparent;border:0;color:#9ca3af;cursor:pointer;padding:4px;border-radius:6px;transition:.18s}
.confirm-close:hover{color:#4b5563;background:#f3f4f6}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    if(!document.getElementById('confirm-overlay')){
        const modalHtml = `\n      <div id=\"confirm-overlay\" class=\"confirm-overlay\">\n        <div class=\"confirm-box\">\n          <button type=\"button\" class=\"confirm-close\" id=\"confirm-x\" aria-label=\"Tutup\">\n            <svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'><path stroke-linecap='round' stroke-linejoin='round' d='M6 18L18 6M6 6l12 12'/></svg>\n          </button>\n          <div class=\"confirm-title\">Konfirmasi Hapus</div>\n          <div class=\"confirm-message\" id=\"confirm-message\">Apakah Anda yakin?</div>\n          <div class=\"confirm-actions\">\n            <button type=\"button\" class=\"confirm-btn cancel\" id=\"confirm-cancel\">Batal</button>\n            <button type=\"button\" class=\"confirm-btn ok\" id=\"confirm-ok\">Ya, Hapus</button>\n          </div>\n        </div>\n      </div>`;
        document.body.insertAdjacentHTML('beforeend', modalHtml);
    }
    const overlay = document.getElementById('confirm-overlay');
    const msgEl = document.getElementById('confirm-message');
    let pendingFormId = null;
    function openConfirm(message, formId){
        pendingFormId = formId; msgEl.textContent = message; overlay.style.display='flex';
    }
    function closeConfirm(){ overlay.style.display='none'; pendingFormId=null; }
    document.querySelectorAll('[data-delete-trigger]').forEach(btn=>{
        btn.addEventListener('click',()=>{openConfirm('Apakah Anda yakin ingin menghapus kategori ini?', btn.getAttribute('data-delete-trigger'));});
    });
    document.getElementById('confirm-cancel').addEventListener('click', closeConfirm);
    document.getElementById('confirm-x').addEventListener('click', closeConfirm);
    document.getElementById('confirm-ok').addEventListener('click', ()=>{ if(pendingFormId){ const f=document.getElementById(pendingFormId); if(f) f.submit(); } closeConfirm(); });
    overlay.addEventListener('click', e=>{ if(e.target===overlay) closeConfirm(); });
    document.addEventListener('keydown', e=>{ if(e.key==='Escape') closeConfirm(); });
});
</script>
@endpush

