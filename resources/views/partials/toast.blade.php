@php
    $types = [
        'success' => 'bg-green-600 border-green-700 text-white',
        'error' => 'bg-red-600 border-red-700 text-white',
        'warning' => 'bg-amber-500 border-amber-600 text-black',
        'info' => 'bg-blue-600 border-blue-700 text-white',
    ];
    $iconSvgs = [
        'success' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>',
        'error' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>',
        'warning' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M4.93 19h14.14c1.54 0 2.5-1.67 1.73-3L13.73 5c-.77-1.33-2.69-1.33-3.46 0L3.2 16c-.77 1.33.19 3 1.73 3z" /></svg>',
        'info' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
    ];
    $currentType = null;
    $message = null;
    foreach ($types as $t => $_) {
        if(session($t)) { $currentType = $t; $message = session($t); break; }
    }
@endphp
@if($currentType && $message)
<div id="toast-root" class="fixed inset-0 z-40 flex items-start justify-center pointer-events-none">
    <div id="toast" class="mt-24 flex items-start gap-3 px-5 py-4 rounded-2xl border shadow-2xl transform transition-all duration-300 opacity-0 -translate-y-4 pointer-events-auto {{$types[$currentType]}}" role="alert" aria-live="assertive" style="min-width:300px;max-width:420px;backdrop-filter:blur(3px);background-clip:padding-box;">
        <div class="shrink-0">{!! $iconSvgs[$currentType] !!}</div>
        <div class="flex-1 leading-snug text-sm font-medium">{{ $message }}</div>
        <button type="button" class="ml-2 text-white/80 hover:text-white focus:outline-none" aria-label="Tutup" onclick="window.__closeToast()">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>
</div>
@push('scripts')
<script>
window.__closeToast = function(){
  const t = document.getElementById('toast');
  if(!t) return; 
  t.classList.add('opacity-0','-translate-y-4');
  setTimeout(()=>{ const root=document.getElementById('toast-root'); if(root) root.remove(); },280);
};
document.addEventListener('DOMContentLoaded', function(){
  const t = document.getElementById('toast');
  if(!t) return;
  requestAnimationFrame(()=>{
    t.classList.remove('opacity-0','-translate-y-4');
    t.classList.add('opacity-100','translate-y-0');
  });
  setTimeout(()=>{ window.__closeToast(); }, 4000);
});
</script>
@endpush
@endif