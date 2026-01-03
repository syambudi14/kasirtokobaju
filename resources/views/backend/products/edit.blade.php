@extends('layouts.app')

@section('title', 'Edit Produk')
@section('header_title', 'Edit Produk')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <a href="{{ url('products') }}"
            class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 mb-6 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
            <span class="font-medium">Kembali ke Daftar Produk</span>
        </a>

        <!-- Validation Errors -->
        @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
            <strong class="font-bold">Ada kesalahan!</strong>
            <span class="block sm:inline">Mohon periksa inputan anda.</span>
            <ul class="mt-2 text-sm list-disc list-inside text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        <!-- Custom Session Errors (like min 2 stock) -->
        @if (session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8">
                <h2 class="text-xl font-bold text-gray-800 mb-1">Informasi Produk</h2>
                <p class="text-sm text-gray-500 mb-8">Update detail produk di bawah ini.</p>

                <form action="{{ url('products/' . $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Left Column: Image Upload -->
                        <div class="md:col-span-1">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Foto Produk</label>
                            
                            @if($product->image)
                                <div class="mb-4 relative group w-full aspect-square rounded-2xl overflow-hidden border border-gray-200">
                                    <img src="{{ asset('uploads/products/' . $product->image) }}" alt="Preview" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                        <p class="text-white text-xs font-bold">Foto Saat Ini</p>
                                    </div>
                                </div>
                            @endif

                            <div x-data="{ photoName: null, photoPreview: null }" class="col-span-6 sm:col-span-4">
                                <input type="file" name="image" class="hidden" x-ref="photo" x-on:change="
                                        photoName = $refs.photo.files[0].name;
                                        const reader = new FileReader();
                                        reader.onload = (e) => {
                                            photoPreview = e.target.result;
                                        };
                                        reader.readAsDataURL($refs.photo.files[0]);
                                    ">

                                <div class="cursor-pointer aspect-square bg-gray-50 rounded-2xl border-2 border-dashed border-gray-300 hover:border-[#4F46E5] hover:bg-[#EEF2FF] transition-all flex flex-col items-center justify-center p-4 group relative overflow-hidden"
                                    x-on:click.prevent="$refs.photo.click()">

                                    <!-- New File Preview -->
                                    <div class="absolute inset-0 z-20" x-show="photoPreview" style="display: none;">
                                        <span class="block w-full h-full bg-cover bg-center bg-no-repeat rounded-2xl"
                                            x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                                        </span>
                                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                                             <p class="text-white text-xs font-bold drop-shadow-md">Foto Baru</p>
                                        </div>
                                    </div>

                                    <!-- Placeholder -->
                                    <div x-show="!photoPreview" class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-16 h-16 bg-white rounded-full shadow-sm flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="text-gray-400 group-hover:text-[#4F46E5]">
                                                <rect width="18" height="18" x="3" y="3" rx="2" ry="2" />
                                                <circle cx="9" cy="9" r="2" />
                                                <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                                            </svg>
                                        </div>
                                        
                                        <p class="text-xs font-bold text-gray-500 group-hover:text-[#4F46E5] text-center">
                                            {{ $product->image ? 'Ganti Foto' : 'Klik untuk upload' }}
                                        </p>
                                        <p class="text-[10px] text-gray-400 text-center mt-1">PNG, JPG up to 5MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Details -->
                        <div class="md:col-span-2 space-y-6">
                            <!-- Name & Code -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Produk</label>
                                    <input type="text" name="name" value="{{ old('name', $product->name) }}" placeholder="Contoh: Kemeja Flannel"
                                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#4F46E5] focus:ring-4 focus:ring-[#4F46E5]/10 transition-all font-medium text-gray-800 placeholder-gray-400"
                                        required>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Kode Barang (SKU)</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <span class="text-gray-400 font-mono text-sm">#</span>
                                        </div>
                                        <input type="text" name="code" value="{{ old('code', $product->code) }}" placeholder="AUTO-GEN"
                                            class="w-full pl-8 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#4F46E5] focus:ring-4 focus:ring-[#4F46E5]/10 transition-all font-mono font-medium text-gray-800 placeholder-gray-400"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <!-- Category & Stock -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                                    <div class="relative">
                                        <select name="category"
                                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#4F46E5] focus:ring-4 focus:ring-[#4F46E5]/10 transition-all font-medium text-gray-800 appearance-none cursor-pointer"
                                            required>
                                            <option value="">Pilih Kategori</option>
                                            <option value="baju" {{ old('category', $product->category) == 'baju' ? 'selected' : '' }}>Baju</option>
                                            <option value="celana" {{ old('category', $product->category) == 'celana' ? 'selected' : '' }}>Celana</option>
                                            <option value="jaket" {{ old('category', $product->category) == 'jaket' ? 'selected' : '' }}>Jaket</option>
                                            <option value="aksesoris" {{ old('category', $product->category) == 'aksesoris' ? 'selected' : '' }}>Aksesoris</option>
                                        </select>
                                        <div
                                            class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="m6 9 6 6 6-6" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <!-- Stock Per Size Matrix -->
                                <div class="col-span-2">
                                    <label class="block text-sm font-bold text-gray-700 mb-3">Stok per Ukuran <span class="text-xs font-normal text-gray-500 ml-1">(Total stok wajib minimal 2)</span></label>
                                    <div class="grid grid-cols-5 gap-3">
                                        <div class="space-y-1">
                                            <div class="text-xs font-bold text-gray-500 text-center uppercase">S</div>
                                            <input type="number" name="stock_s" value="{{ old('stock_s', $product->stock_s) }}" placeholder="0" min="0"
                                                class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#4F46E5] focus:ring-2 focus:ring-[#4F46E5]/10 text-center font-bold text-gray-800">
                                        </div>
                                        <div class="space-y-1">
                                            <div class="text-xs font-bold text-gray-500 text-center uppercase">M</div>
                                            <input type="number" name="stock_m" value="{{ old('stock_m', $product->stock_m) }}" placeholder="0" min="0"
                                                class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#4F46E5] focus:ring-2 focus:ring-[#4F46E5]/10 text-center font-bold text-gray-800">
                                        </div>
                                        <div class="space-y-1">
                                            <div class="text-xs font-bold text-gray-500 text-center uppercase">L</div>
                                            <input type="number" name="stock_l" value="{{ old('stock_l', $product->stock_l) }}" placeholder="0" min="0"
                                                class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#4F46E5] focus:ring-2 focus:ring-[#4F46E5]/10 text-center font-bold text-gray-800">
                                        </div>
                                        <div class="space-y-1">
                                            <div class="text-xs font-bold text-gray-500 text-center uppercase">XL</div>
                                            <input type="number" name="stock_xl" value="{{ old('stock_xl', $product->stock_xl) }}" placeholder="0" min="0"
                                                class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#4F46E5] focus:ring-2 focus:ring-[#4F46E5]/10 text-center font-bold text-gray-800">
                                        </div>
                                        <div class="space-y-1">
                                            <div class="text-xs font-bold text-gray-500 text-center uppercase">XXL</div>
                                            <input type="number" name="stock_xxl" value="{{ old('stock_xxl', $product->stock_xxl) }}" placeholder="0" min="0"
                                                class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#4F46E5] focus:ring-2 focus:ring-[#4F46E5]/10 text-center font-bold text-gray-800">
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- End of Category/Stock Grid -->

                            <!-- Price Section (Moved out of grid) -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Harga Jual</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-gray-500 font-bold text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="price" value="{{ old('price', $product->price) }}" placeholder="0" min="0"
                                        class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#4F46E5] focus:ring-4 focus:ring-[#4F46E5]/10 transition-all font-bold text-gray-800 placeholder-gray-400 text-lg"
                                        required>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi (Opsional)</label>
                                <textarea name="description" rows="3" placeholder="Tuliskan detail produk disini..."
                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#4F46E5] focus:ring-4 focus:ring-[#4F46E5]/10 transition-all font-medium text-gray-800 placeholder-gray-400 resize-none">{{ old('description', $product->description) }}</textarea>
                            </div>

                            <!-- Actions -->
                            <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-4">
                                <a href="{{ url('products') }}"
                                    class="px-6 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-bold text-sm hover:bg-gray-50 transition-all">Batal</a>
                                <button type="submit"
                                    class="px-6 py-2.5 rounded-xl bg-[#4F46E5] text-white font-bold text-sm shadow-lg shadow-indigo-500/30 hover:bg-[#4338ca] transition-all transform active:scale-95 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                        <polyline points="17 21 17 13 7 13 7 21" />
                                        <polyline points="7 3 7 8 15 8" />
                                    </svg>
                                    Update Produk
                                </button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
