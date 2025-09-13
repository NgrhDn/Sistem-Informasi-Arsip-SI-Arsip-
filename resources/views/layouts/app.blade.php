<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Arsip Surat')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f0f2f5; }
        .sidebar-item.active { background-color: #4f46e5; color: white; }
    </style>
    @stack('styles')
</head>
<body class="flex h-screen">

    <aside class="w-64 bg-white shadow-lg flex-shrink-0 flex flex-col">
        <div class="p-6 border-b">
            <h1 class="text-2xl font-bold text-indigo-600">Arsip Surat</h1>
            <p class="text-sm text-gray-500">Kel. Karangduren</p>
        </div>
        <nav class="p-4 space-y-2 flex-grow">
            <a href="{{ route('arsip.index') }}" class="sidebar-item flex items-center p-3 rounded-lg transition duration-200 hover:bg-indigo-500 hover:text-white {{ request()->routeIs('arsip.*') ? 'active' : '' }}">
                <i class="fas fa-star w-6 text-center"></i>
                <span class="ml-3">Arsip</span>
            </a>
            <a href="{{ route('kategori.index') }}" class="sidebar-item flex items-center p-3 rounded-lg transition duration-200 hover:bg-indigo-500 hover:text-white {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                <i class="fas fa-cog w-6 text-center"></i>
                <span class="ml-3">Kategori Surat</span>
            </a>
            <a href="{{ route('about') }}" class="sidebar-item flex items-center p-3 rounded-lg transition duration-200 hover:bg-indigo-500 hover:text-white {{ request()->routeIs('about') ? 'active' : '' }}">
                <i class="fas fa-info-circle w-6 text-center"></i>
                <span class="ml-3">About</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto">
    @include('partials.toast')
        @yield('content')
    </main>

    <script>
    function confirmDelete(event) {
        event.preventDefault();
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            document.getElementById(event.target.dataset.formId).submit();
        }
    }
    </script>
    @stack('scripts')
</body>
</html>
