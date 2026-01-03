<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Kasir') | Kasir Toko Baju</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        // Palette: https://colorhunt.co/palette/ffe6e6f2d1d1daeaf1c6dce4
                        pastel: {
                            100: '#FFE6E6', // Lightest Pink
                            200: '#F2D1D1', // Pink
                            300: '#DAEAF1', // Pale Blue
                            400: '#C6DCE4', // Blue Gray
                        },
                        primary: '#C6DCE4', 
                        secondary: '#F2D1D1',
                        surface: '#FFFFFF',
                        bg: '#FFE6E6', 
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #FDF2F2; /* Subtle pink tint based on #FFE6E6 */
        }
        .sidebar {
            transition: all 0.3s ease;
            background-color: #FFFFFF;
        }
        .nav-item.active {
            background-color: #C6DCE4; /* Pastel 400 */
            color: #1F2937; /* Gray 800 */
            font-weight: 600;
        }
        .nav-item:hover:not(.active) {
            background-color: #FFE6E6; /* Pastel 100 */
            color: #374151;
        }
        .glass-header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #F2D1D1; /* Pastel 200 */
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-[#FDF2F2]">

    <!-- Sidebar -->
    <aside class="sidebar w-64 border-r border-[#F2D1D1] hidden md:flex flex-col z-20 shadow-sm">
        <div class="h-16 flex items-center px-6 border-b border-[#F2D1D1]">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-[#C6DCE4] flex items-center justify-center text-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.91 8.84 10 12l.91-9.16a1 1 0 0 1 1.62-.06L22.5 12h-12"></path><path d="M2 19h20"></path><path d="M9 19v-4.36a3 3 0 1 1 6 0V19"></path></svg>
                </div>
                <span class="text-xl font-bold text-gray-800 tracking-tight">KasirBaju</span>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto py-4">
            <ul class="space-y-1 px-3">
                <li>
                    <a href="{{ url('/dashboard') }}" class="nav-item flex items-center gap-3 px-3 py-3 rounded-lg text-gray-600 transition-colors {{ request()->is('dashboard*') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/cashier') }}" class="nav-item flex items-center gap-3 px-3 py-3 rounded-lg text-gray-600 transition-colors {{ request()->is('cashier*') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                        <span>Kasir</span>
                    </a>
                </li>
                @if(auth()->user()->role === 'admin')
                <li>
                    <a href="{{ url('/products') }}" class="nav-item flex items-center gap-3 px-3 py-3 rounded-lg text-gray-600 transition-colors {{ request()->is('products*') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                        <span>Produk</span>
                    </a>
                </li>
                @endif
                <li>
                    <a href="{{ url('/reports') }}" class="nav-item flex items-center gap-3 px-3 py-3 rounded-lg text-gray-600 transition-colors {{ request()->is('reports*') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="M16 13H8"/><path d="M16 17H8"/><path d="M10 9H8"/></svg>
                        <span>Laporan</span>
                    </a>
                </li>
                @if(auth()->user()->role === 'admin')
                <li>
                    <a href="{{ url('/settings') }}" class="nav-item flex items-center gap-3 px-3 py-3 rounded-lg text-gray-600 transition-colors {{ request()->is('settings*') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.1a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                        <span>Pengaturan</span>
                    </a>
                </li>
                @endif
            </ul>
        </nav>

        <div class="p-4 border-t border-[#F2D1D1]">
            <a href="{{ url('/logout') }}" class="flex items-center gap-3 px-3 py-3 rounded-lg text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                <span>Keluar</span>
            </a>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <!-- Header -->
        <header class="h-16 glass-header z-10 sticky top-0 px-6 flex items-center justify-between">
            <div class="flex items-center md:hidden">
                <button class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
                </button>
            </div>

            <!-- Page Title -->
            <div class="hidden md:block">
                <h1 class="text-xl font-semibold text-gray-800">@yield('header_title', 'Dashboard')</h1>
            </div>

            <!-- User Menu -->
            <div class="flex items-center gap-4">
                <div class="relative">
                    <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-[#F2D1D1] border-2 border-white rounded-full"></span>
                    <button class="p-2 text-gray-500 hover:text-gray-700 hover:bg-[#FFE6E6] rounded-full transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                    </button>
                </div>
                
                <div class="flex items-center gap-3 pl-4 border-l border-[#F2D1D1]">
                    <div class="text-right hidden md:block">
                        <p class="text-sm font-medium text-gray-800">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-[#FFE6E6] flex items-center justify-center text-gray-700 font-bold border-2 border-white shadow-sm">
                        {{ substr(auth()->user()->name, 0, 2) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto p-6 scroll-smooth">
            @yield('content')
        </main>
        
    </div>

</body>
</html>