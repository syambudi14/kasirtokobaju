@extends('layouts.app')

@section('title', 'Pengaturan')
@section('header_title', 'Pengaturan Toko')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8">

        <!-- Profile & Store Settings -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="border-b border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-800">Profil Toko</h2>
                <p class="text-sm text-gray-500">Informasi ini akan ditampilkan pada struk belanja.</p>
            </div>
            <div class="p-8">
                <form action="#" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Logo Upload -->
                        <div class="md:col-span-1">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Logo Toko</label>
                            <div
                                class="aspect-square bg-gray-50 rounded-2xl border-2 border-dashed border-gray-300 hover:border-[#4F46E5] hover:bg-[#EEF2FF] transition-all cursor-pointer flex flex-col items-center justify-center p-4 group relative overflow-hidden">
                                <div
                                    class="w-20 h-20 bg-white rounded-full shadow-sm flex items-center justify-center mb-4">
                                    <span class="text-2xl font-bold text-gray-400">LT</span>
                                </div>
                                <button type="button"
                                    class="text-xs font-bold text-[#4F46E5] bg-white px-3 py-1.5 rounded-full shadow-sm hover:shadow-md transition-all">Ganti
                                    Logo</button>
                            </div>
                        </div>

                        <!-- Form Fields -->
                        <div class="md:col-span-2 space-y-5">
                            <div class="grid grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Toko</label>
                                    <input type="text" value="Kasir Toko Baju"
                                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#4F46E5] focus:ring-4 focus:ring-[#4F46E5]/10 font-medium text-gray-800">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">No. Telepon</label>
                                    <input type="text" value="+62 812 3456 7890"
                                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#4F46E5] focus:ring-4 focus:ring-[#4F46E5]/10 font-medium text-gray-800">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap</label>
                                <textarea rows="3"
                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#4F46E5] focus:ring-4 focus:ring-[#4F46E5]/10 font-medium text-gray-800 resize-none">Jl. Jendral Sudirman No. 123, Jakarta Pusat</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Pesan Footer Struk</label>
                                <input type="text" value="Terima kasih telah berbelanja di toko kami!"
                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#4F46E5] focus:ring-4 focus:ring-[#4F46E5]/10 font-medium text-gray-800">
                                <p class="text-[10px] text-gray-400 mt-1">Pesan ini akan muncul di bagian paling bawah
                                    struk.</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100 flex justify-end">
                        <button type="button"
                            class="px-6 py-2.5 rounded-xl bg-[#4F46E5] text-white font-bold text-sm shadow-lg shadow-indigo-500/30 hover:bg-[#4338ca] transition-all">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Application Settings -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Printer Settings -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col h-full">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="text-gray-400">
                        <polyline points="6 9 6 2 18 2 18 9" />
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                        <rect width="12" height="8" x="6" y="14" />
                    </svg>
                    Pengaturan Printer
                </h3>
                <div class="space-y-4 flex-1">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Ukuran Kertas</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="paper_size" class="text-[#4F46E5] focus:ring-[#4F46E5]" checked>
                                <span class="text-sm font-medium text-gray-700">Thermal 58mm</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="paper_size" class="text-[#4F46E5] focus:ring-[#4F46E5]">
                                <span class="text-sm font-medium text-gray-700">Thermal 80mm</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100">
                        <span class="text-sm font-medium text-gray-600">Auto Print Struk</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" checked>
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#4F46E5]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#4F46E5]">
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Account Security -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col h-full">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="text-gray-400">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    Keamanan Akun
                </h3>
                <div class="space-y-4 flex-1">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Email Administrator</label>
                        <input type="email" value="admin@tokobaju.com"
                            class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-gray-500" disabled>
                    </div>
                    <button
                        class="w-full px-4 py-2 border border-red-200 text-red-600 font-bold text-sm rounded-xl hover:bg-red-50 transition-colors flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4" />
                        </svg>
                        Ganti Password
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection