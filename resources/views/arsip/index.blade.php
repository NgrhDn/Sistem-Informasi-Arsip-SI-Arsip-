@extends('layouts.app')

@section('title', 'Arsip Surat')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-2">Arsip Surat</h1>
    <p class="text-gray-600 mb-6">Berikut ini adalah surat-surat yang telah terbit dan diarsipkan. <br>Klik "Lihat" pada kolom aksi untuk menampilkan surat.</p>

    
    <div class="bg-white p-6 rounded-lg shadow-md">
    <form action="{{ route('arsip.index') }}" method="GET" class="flex flex-wrap items-center gap-3 mb-4">
            <div class="flex items-center flex-grow min-w-[240px]">
                <label for="search" class="mr-2 font-semibold whitespace-nowrap">Cari:</label>
                <input type="text" name="search" id="search" class="border rounded-lg p-2 flex-grow" placeholder="Nomor Surat / Kategori / Judul" value="{{ request('search') }}">
            </div>
            <button type="submit" class="bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700">Cari</button>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Nomor Surat</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Kategori</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Judul</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Waktu Pengarsipan</th>
                        <th class="text-center py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suratList as $surat)
                        <tr class="border-b">
                            <td class="py-3 px-4">{{ $surat->nomor_surat }}</td>
                            <td class="py-3 px-4">{{ $surat->kategori->nama_kategori }}</td>
                            <td class="py-3 px-4">{{ $surat->judul }}</td>
                            <td class="py-3 px-4">{{ $surat->created_at->format('d-m-Y H:i:s') }}</td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <form id="delete-form-{{ $surat->id_surat }}" action="{{ route('arsip.destroy', $surat->id_surat) }}" method="POST" class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" data-delete-trigger="delete-form-{{ $surat->id_surat }}" class="w-20 bg-red-500 text-white font-bold py-1 rounded-lg hover:bg-red-600 text-sm">Hapus</button>
                                    </form>
                                    <a href="{{ route('arsip.download', $surat->id_surat) }}" class="w-20 inline-flex justify-center bg-yellow-500 text-white font-bold py-1 rounded-lg hover:bg-yellow-600 text-sm">Unduh</a>
                                    <a href="{{ route('arsip.show', $surat->id_surat) }}" class="w-20 inline-flex justify-center bg-blue-500 text-white font-bold py-1 rounded-lg hover:bg-blue-600 text-sm">Lihat &gt;&gt;</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">Tidak ada data surat yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <a href="{{ route('arsip.create') }}" class="mt-6 inline-block bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700">
        <i class="fas fa-plus mr-2"></i> Arsipkan Surat
    </a>
</div>
@endsection

@push('styles')
<style>
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
    const modalHtml = `\n      <div id="confirm-overlay" class="confirm-overlay">\n        <div class="confirm-box">\n          <button type="button" class="confirm-close" id="confirm-x" aria-label="Tutup">\n            <svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'><path stroke-linecap='round' stroke-linejoin='round' d='M6 18L18 6M6 6l12 12'/></svg>\n          </button>\n          <div class="confirm-title">Konfirmasi Hapus</div>\n          <div class="confirm-message" id="confirm-message">Apakah Anda yakin?</div>\n          <div class="confirm-actions">\n            <button type="button" class="confirm-btn cancel" id="confirm-cancel">Batal</button>\n            <button type="button" class="confirm-btn ok" id="confirm-ok">Ya, Hapus</button>\n          </div>\n        </div>\n      </div>`;
        document.body.insertAdjacentHTML('beforeend', modalHtml);
    }

    const overlay = document.getElementById('confirm-overlay');
    const msgEl = document.getElementById('confirm-message');
    let pendingFormId = null;

    function openConfirm(message, formId){
        pendingFormId = formId;
        msgEl.textContent = message;
        overlay.style.display = 'flex';
    }
    function closeConfirm(){
        overlay.style.display = 'none';
        pendingFormId = null;
    }

    document.querySelectorAll('[data-delete-trigger]').forEach(btn => {
        btn.addEventListener('click', () => {
            const formId = btn.getAttribute('data-delete-trigger');
            openConfirm('Apakah Anda yakin ingin menghapus arsip surat ini?', formId);
        });
    });

    document.getElementById('confirm-cancel').addEventListener('click', closeConfirm);
    document.getElementById('confirm-x').addEventListener('click', closeConfirm);
    document.getElementById('confirm-ok').addEventListener('click', () => {
        if(pendingFormId){
            const form = document.getElementById(pendingFormId);
            if(form) form.submit();
        }
        closeConfirm();
    });
    overlay.addEventListener('click', e => { if(e.target === overlay) closeConfirm(); });
    document.addEventListener('keydown', e => { if(e.key === 'Escape') closeConfirm(); });
});
</script>
@endpush
