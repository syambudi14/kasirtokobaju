@extends('layouts.app')

@section('title', 'Produk')
@section('header_title', 'Inventaris Produk')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden" x-data="productTable()">
    
    <!-- Alerts -->
    @if(session('success'))
    <div class="bg-green-50 text-green-700 p-4 border-b border-green-100 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <p class="font-medium text-sm">{{ session('success') }}</p>
    </div>
    @endif
    
    @if(session('error'))
    <div class="bg-red-50 text-red-700 p-4 border-b border-red-100 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
        <p class="font-medium text-sm">{{ session('error') }}</p>
    </div>
    @endif

    <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <form action="{{ url('products') }}" method="GET" class="flex items-center gap-4 flex-1">
            <div class="relative w-full md:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Cari produk...">
            </div>
            <div class="flex items-center gap-2">
                <button type="submit"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" />
                    </svg>
                    Filter
                </button>
            </div>
        </form>
        <a href="{{ url('products/create') }}"
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 flex items-center gap-2 shadow-sm transition-all hover:shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" x2="12" y1="5" y2="19" />
                <line x1="5" x2="19" y1="12" y2="12" />
            </svg>
            Tambah Produk
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 text-left">
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Gambar</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Produk</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Stok</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        @if($product->image)
                        <img src="{{ asset('uploads/products/'.$product->image) }}" alt="{{ $product->name }}" class="h-10 w-10 rounded-lg object-cover">
                        @else
                        <div class="h-10 w-10 rounded-lg flex items-center justify-center text-indigo-500 bg-indigo-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M20.38 3.4a2 2 0 0 0-2.83 0L5 15.94a2 2 0 0 0-.55.9l-1 5a1 1 0 0 0 1.2 1.2l5-1a2 2 0 0 0 .9-.55L20.38 6.23a2 2 0 0 0 0-2.83Z" />
                            </svg>
                        </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm font-mono text-gray-500">{{ $product->code }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $product->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ ucfirst($product->category) }}</td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ 'Rp ' . number_format($product->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 font-mono">{{ $product->total_stock }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->total_stock > 10 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $product->total_stock > 10 ? 'Tersedia' : 'Menipis' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <!-- Detail Button (Eye) -->
                            <button @click='openDetailModal(@json($product))'
                                class="p-1.5 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors"
                                title="Lihat Detail Stok">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                            <!-- Add Stock Button (+) -->
                            <button @click='openAddStockModal(@json($product))'
                                class="p-1.5 text-green-500 hover:bg-green-50 rounded-lg transition-colors"
                                title="Tambah Stok">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect width="18" height="18" x="3" y="3" rx="2" />
                                    <path d="M12 8v8" />
                                    <path d="M8 12h8" />
                                </svg>
                            </button>
                            <!-- Edit Button -->
                            <a href="{{ url('products/' . $product->id . '/edit') }}"
                                class="p-1.5 text-gray-400 hover:bg-gray-100 hover:text-indigo-600 rounded-lg transition-colors"
                                title="Edit Produk">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                    <path d="m15 5 4 4" />
                                </svg>
                            </a>
                            <!-- Delete Button -->
                            <form action="{{ url('products/' . $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-gray-400 hover:bg-red-50 hover:text-red-600 rounded-lg transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M3 6h18" />
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                        <line x1="10" x2="10" y1="11" y2="17" />
                                        <line x1="14" x2="14" y1="11" y2="17" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                        Belum ada data produk.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <!-- Ideally usage of $products->links() here if pagination is enabled -->

    <!-- Detail Modal -->
    <div x-show="showDetailModal" class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="display: none;">
        <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="closeDetailModal">
        </div>
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform transition-all">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900" x-text="selectedProduct?.name"></h3>
                        <p class="text-sm text-gray-500">SKU: <span x-text="selectedProduct?.code"></span></p>
                    </div>
                    <button @click="closeDetailModal" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" x2="6" y1="6" y2="18" />
                            <line x1="6" x2="18" y1="6" y2="18" />
                        </svg>
                    </button>
                </div>

                <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Detail Stok per Ukuran</h4>
                <div class="grid grid-cols-2 gap-3 mb-6">
                    <!-- Manually mapping sizes since structure is flat in DB now -->
                    <div class="bg-gray-50 rounded-lg p-3 border border-gray-100 flex justify-between items-center">
                        <span class="font-bold text-gray-700 bg-white border border-gray-200 w-8 h-8 flex items-center justify-center rounded-md text-xs shadow-sm">S</span>
                        <div class="flex gap-1 items-baseline">
                            <span class="text-lg font-bold text-[#4F46E5]" x-text="selectedProduct?.stock_s"></span>
                            <span class="text-xs text-gray-500">pcs</span>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3 border border-gray-100 flex justify-between items-center">
                        <span class="font-bold text-gray-700 bg-white border border-gray-200 w-8 h-8 flex items-center justify-center rounded-md text-xs shadow-sm">M</span>
                        <div class="flex gap-1 items-baseline">
                            <span class="text-lg font-bold text-[#4F46E5]" x-text="selectedProduct?.stock_m"></span>
                            <span class="text-xs text-gray-500">pcs</span>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3 border border-gray-100 flex justify-between items-center">
                        <span class="font-bold text-gray-700 bg-white border border-gray-200 w-8 h-8 flex items-center justify-center rounded-md text-xs shadow-sm">L</span>
                        <div class="flex gap-1 items-baseline">
                            <span class="text-lg font-bold text-[#4F46E5]" x-text="selectedProduct?.stock_l"></span>
                            <span class="text-xs text-gray-500">pcs</span>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3 border border-gray-100 flex justify-between items-center">
                        <span class="font-bold text-gray-700 bg-white border border-gray-200 w-8 h-8 flex items-center justify-center rounded-md text-xs shadow-sm">XL</span>
                        <div class="flex gap-1 items-baseline">
                            <span class="text-lg font-bold text-[#4F46E5]" x-text="selectedProduct?.stock_xl"></span>
                            <span class="text-xs text-gray-500">pcs</span>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3 border border-gray-100 flex justify-between items-center">
                        <span class="font-bold text-gray-700 bg-white border border-gray-200 w-8 h-8 flex items-center justify-center rounded-md text-xs shadow-sm">XXL</span>
                        <div class="flex gap-1 items-baseline">
                            <span class="text-lg font-bold text-[#4F46E5]" x-text="selectedProduct?.stock_xxl"></span>
                            <span class="text-xs text-gray-500">pcs</span>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 text-blue-700 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" x2="12" y1="8" y2="12" />
                        <line x1="12" x2="12.01" y1="16" y2="16" />
                    </svg>
                    <p>Total Stok Keseluruhan: <span class="font-bold" x-text="selectedProduct?.total_stock"></span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Stock Modal -->
    <div x-show="showAddStockModal" class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="display: none;">
        <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="closeAddStockModal">
        </div>
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm overflow-hidden transform transition-all">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Tambah Stok</h3>
                        <p class="text-sm text-gray-500" x-text="selectedProduct?.name"></p>
                    </div>
                    <button @click="closeAddStockModal" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" x2="6" y1="6" y2="18" />
                            <line x1="6" x2="18" y1="6" y2="18" />
                        </svg>
                    </button>
                </div>

                <form :action="'{{ url('products') }}/' + selectedProduct?.id + '/add-stock'" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2 uppercase">Pilih Ukuran</label>
                        <select name="size"
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#4F46E5] focus:ring-4 focus:ring-[#4F46E5]/10 font-medium text-gray-800">
                            <option value="s">S (Saat ini: <span x-text="selectedProduct?.stock_s"></span>)</option>
                            <option value="m">M (Saat ini: <span x-text="selectedProduct?.stock_m"></span>)</option>
                            <option value="l">L (Saat ini: <span x-text="selectedProduct?.stock_l"></span>)</option>
                            <option value="xl">XL (Saat ini: <span x-text="selectedProduct?.stock_xl"></span>)</option>
                            <option value="xxl">XXL (Saat ini: <span x-text="selectedProduct?.stock_xxl"></span>)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2 uppercase">Jumlah Penambahan</label>
                        <input type="number" name="qty" placeholder="0" min="1" required
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#4F46E5] focus:ring-4 focus:ring-[#4F46E5]/10 font-bold text-gray-800">
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full py-3 rounded-xl bg-green-600 text-white font-bold text-sm shadow-lg shadow-green-500/30 hover:bg-green-700 transition-all flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M5 12h14" />
                                <path d="M12 5l7 7-7 7" />
                            </svg>
                            Simpan Stok Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- Alpine.js Logic -->
<script>
    function productTable() {
        return {
            showDetailModal: false,
            showAddStockModal: false,
            selectedProduct: null,

            openDetailModal(product) {
                this.selectedProduct = product;
                this.showDetailModal = true;
            },
            closeDetailModal() {
                this.showDetailModal = false;
            },
            openAddStockModal(product) {
                this.selectedProduct = product;
                this.showAddStockModal = true;
            },
            closeAddStockModal() {
                this.showAddStockModal = false;
            },
            formatCurrency(value) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
            }
        }
    }
</script>
<script src="//unpkg.com/alpinejs" defer></script>
@endsection