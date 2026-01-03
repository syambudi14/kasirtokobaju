<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | Kasir Toko Baju</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        pastel: {
                            100: '#FFE6E6',
                            200: '#F2D1D1',
                            300: '#DAEAF1',
                            400: '#C6DCE4',
                        },
                        primary: '#C6DCE4',
                        secondary: '#F2D1D1',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #FDF2F2;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="h-screen w-full flex items-center justify-center bg-[#FFE6E6] overflow-hidden p-4 relative">
    
    <!-- Decorative Elements -->
    <div class="absolute w-96 h-96 bg-[#DAEAF1] rounded-full -top-20 -left-20 blur-3xl opacity-50"></div>
    <div class="absolute w-96 h-96 bg-[#C6DCE4] rounded-full -bottom-20 -right-20 blur-3xl opacity-50"></div>

    <div class="w-full max-w-md glass-effect rounded-2xl shadow-2xl p-8 transform hover:scale-[1.01] transition-all duration-300 relative z-10 border border-[#F2D1D1]">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-[#C6DCE4] text-gray-800 mb-4 shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.91 8.84 10 12l.91-9.16a1 1 0 0 1 1.62-.06L22.5 12h-12"></path><path d="M2 19h20"></path><path d="M9 19v-4.36a3 3 0 1 1 6 0V19"></path></svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang</h1>
            <p class="text-gray-500 text-sm">Silakan masuk untuk mengakses sistem kasir</p>
        </div>

        <form action="{{ url('/login') }}" method="POST" class="space-y-6">
            @csrf
            
            @if ($errors->any())
                <div class="bg-red-50 text-red-700 p-4 rounded-xl text-sm border border-red-100 flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 mt-0.5"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                    <div>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    </div>
                    <input type="email" id="email" name="email" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C6DCE4] focus:border-[#C6DCE4] transition-colors shadow-sm sm:text-sm" placeholder="nama@email.com" required>
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </div>
                    <input type="password" id="password" name="password" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C6DCE4] focus:border-[#C6DCE4] transition-colors shadow-sm sm:text-sm" placeholder="••••••••" required>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-[#C6DCE4] focus:ring-[#C6DCE4] border-gray-300 rounded cursor-pointer">
                    <label for="remember" class="ml-2 block text-sm text-gray-700 cursor-pointer">
                        Ingat Saya
                    </label>
                </div>

                <div class="text-sm">
                    <a href="#" class="font-medium text-gray-600 hover:text-gray-900 transition-colors">
                        Lupa kata sandi?
                    </a>
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-gray-800 bg-[#C6DCE4] hover:bg-[#DAEAF1] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#C6DCE4] shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-gray-600 group-hover:text-gray-800 transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    Masuk Sekarang
                </button>
            </div>
            
            <div class="mt-6 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} Kasir Toko Baju. Hak Cipta Dilindungi.
            </div>
        </form>
    </div>
</body>
</html>