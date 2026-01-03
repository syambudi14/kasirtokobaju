@extends('layouts.app')

@section('title', 'Kasir POS')
@section('header_title', 'Point of Sales')

@section('content')
    <!-- Main POS Container (Pastel Theme Adjusted) -->
    <div class="h-[calc(100vh-8rem)] flex flex-col gap-6" x-data="posData()">
        
        <!-- Top Bar: Input & Total -->
        <div class="flex flex-col md:flex-row gap-6 h-auto md:h-24 shrink-0">
            <!-- Left: Input Area -->
            <div class="flex-1 bg-white rounded-xl shadow-sm border border-gray-200 p-4 flex flex-col justify-center gap-2 relative z-30 group">
                <div class="flex items-center gap-2 mb-0.5 z-10">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wide">Cari Item</label>
                </div>
                <div class="relative w-full z-10">
                     <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    </div>
                    <input type="text" 
                           x-model="searchQuery"
                           @input="handleSearch"
                           @keydown.escape="showProductModal = false"
                           placeholder="Ketik nama barang, kode..." 
                           class="block w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-300 rounded-lg text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#C6DCE4] focus:ring-2 focus:ring-[#C6DCE4]/20 transition-all text-sm font-medium shadow-inner">
                    <button class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600" @click="searchQuery = ''; showProductModal = false" x-show="searchQuery.length > 0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                    </button>

                    <!-- Dropdown Results (Inline List) -->
                    <div x-show="showProductModal" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         @click.outside="showProductModal = false"
                         class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden z-50 max-h-[400px] flex flex-col ring-1 ring-black/5">
                        
                        <div class="px-4 py-2 border-b border-gray-100 bg-gray-50 flex items-center justify-between text-xs font-medium text-gray-500">
                             <span x-text="'Menampilkan ' + filteredProducts.length + ' hasil'"></span>
                             <button @click="showProductModal = false" class="hover:text-gray-800 transition-colors">Tutup</button>
                        </div>
                        
                        <div class="overflow-y-auto flex-1 p-2">
                             <template x-if="filteredProducts.length === 0">
                                <div class="p-6 text-center text-sm text-gray-500 flex flex-col items-center gap-2">
                                    <svg class="w-8 h-8 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <span>Produk tidak ditemukan.</span>
                                </div>
                             </template>
                             
                             <ul class="space-y-1">
                                <template x-for="product in filteredProducts" :key="product.id">
                                    <li @click="openSizeModal(product)" class="p-2 hover:bg-[#F1F5F9] rounded-lg cursor-pointer flex items-center gap-3 transition-colors group">
                                         <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 border border-black/5" :class="product.bgClass">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :class="product.textClass"><path d="M20.38 3.4a2 2 0 0 0-2.83 0L5 15.94a2 2 0 0 0-.55.9l-1 5a1 1 0 0 0 1.2 1.2l5-1a2 2 0 0 0 .9-.55L20.38 6.23a2 2 0 0 0 0-2.83Z"/></svg>
                                         </div>
                                         <div class="flex-1 min-w-0">
                                             <h4 class="font-bold text-gray-800 text-sm truncate group-hover:text-[#4F46E5] transition-colors" x-text="product.name"></h4>
                                             <p class="text-[10px] text-gray-500 truncate" x-text="product.category"></p>
                                         </div>
                                         <div class="text-right">
                                             <div class="text-[#4F46E5] font-bold text-sm" x-text="'Rp ' + formatNumber(product.price)"></div>
                                         </div>
                                    </li>
                                </template>
                             </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Big Total Display -->
            <div class="w-full md:w-1/3 bg-gray-900 rounded-xl shadow-lg border border-gray-800 p-4 flex flex-col justify-between items-end relative overflow-hidden text-white">
                <div class="absolute top-0 right-0 w-32 h-32 bg-[#C6DCE4] rounded-full blur-[60px] opacity-20"></div>
                <span class="text-gray-400 font-bold text-xs uppercase tracking-widest z-10">Total Pembayaran</span>
                <div class="text-4xl md:text-5xl font-extrabold text-[#C6DCE4] tracking-tight z-10 drop-shadow-lg">
                    <span class="text-xl font-semibold mr-1 text-gray-500">Rp</span><span x-text="formatNumber(cartTotal)">0</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons (Restored & Simplified) -->
        <div class="flex gap-4 shrink-0">
            <button @click="resetCart" class="px-5 py-2.5 bg-white border border-gray-200 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                TRANSAKSI BARU
            </button>
            <button class="px-5 py-2.5 bg-white border border-gray-200 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                SIMPAN DRAFT
            </button>
            <button class="px-5 py-2.5 bg-white border border-gray-200 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                BUKA DRAFT
            </button>
            <div class="flex-1"></div> <!-- Spacer -->
            <button @click="submitTransaction" class="px-6 py-2.5 bg-[#4F46E5] text-white border border-[#4F46E5] rounded-lg text-sm font-bold hover:bg-[#4338ca] hover:border-[#4338ca] transition-all shadow-lg shadow-indigo-500/30 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                BAYAR SEKARANG
            </button>
        </div>

        <!-- Main Content: Table -->
        <div class="flex-1 flex overflow-hidden">
            
            <!-- Transaction Table -->
            <div class="flex-1 bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col overflow-hidden">
                <!-- Table Header -->
                <div class="bg-gray-50 border-b border-gray-200 px-6 py-3 flex text-xs font-extrabold text-gray-500 uppercase tracking-wider">
                    <div class="w-12 text-center">No</div>
                    <div class="w-32">Kode Item</div>
                    <div class="flex-1">Nama Item</div>
                    <div class="w-24 text-center">Ukuran</div>
                    <div class="w-32 text-center">Qty</div>
                    <div class="w-40 text-right">Harga</div>
                    <!-- Disc removed here -->
                    <div class="w-40 text-right">Subtotal</div>
                    <div class="w-16 text-center"></div>
                </div>

                <!-- Table Body -->
                <div class="flex-1 overflow-y-auto bg-white">
                    <template x-if="cart.length === 0">
                        <div class="h-full flex flex-col items-center justify-center text-gray-400">
                             <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                             </div>
                            <p class="text-sm font-medium text-gray-500">Belum ada item ditambahkan</p>
                            <p class="text-xs mt-1 text-gray-400">Scan barcode atau cari item untuk memulai</p>
                        </div>
                    </template>
                    
                    <template x-for="(item, index) in cart" :key="index">
                        <div class="flex items-center px-6 py-3 border-b border-gray-50 hover:bg-[#F8FAFC] transition-colors group text-sm">
                            <div class="w-12 text-center font-bold text-gray-400" x-text="index + 1"></div>
                            <div class="w-32 font-mono font-medium text-gray-500" x-text="'ITM-' + String(index+1).padStart(3, '0')"></div>
                            <div class="flex-1 font-bold text-gray-800">
                                <div x-text="item.name"></div>
                                <div class="text-[10px] text-gray-400 font-normal" x-text="item.category"></div>
                            </div>
                            <div class="w-24 text-center">
                                <span class="bg-[#DAEAF1] text-[#475569] text-[10px] px-2 py-0.5 rounded font-bold shadow-sm border border-[#C6DCE4]" x-text="item.size"></span>
                            </div>
                             <div class="w-32 flex justify-center">
                                <div class="flex items-center border border-gray-300 rounded-md bg-white h-8 shadow-sm">
                                    <button @click="item.qty > 1 ? item.qty-- : removeItem(index)" class="w-8 h-full flex items-center justify-center text-gray-500 hover:text-red-500 hover:bg-red-50 rounded-l-md transition-colors font-bold z-10 relative">-</button>
                                    <input type="text" x-model="item.qty" class="w-10 text-center text-xs font-bold border-x border-gray-200 focus:ring-0 p-0 h-full text-gray-800" readonly>
                                    <button @click="item.qty++" class="w-8 h-full flex items-center justify-center text-gray-500 hover:text-[#4F46E5] hover:bg-indigo-50 rounded-r-md transition-colors font-bold z-10 relative">+</button>
                                </div>
                            </div>
                            <div class="w-40 text-right font-mono font-medium text-gray-600" x-text="formatNumber(item.price)"></div>
                            <!-- Subtotal -->
                            <div class="w-40 text-right font-bold text-gray-900" x-text="formatNumber(item.price * item.qty)"></div>
                            <div class="w-16 flex justify-center opacity-0 group-hover:opacity-100 transition-opacity pl-2">
                                <button @click="removeItem(index)" class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Footer Totals -->
                <div class="bg-white border-t border-gray-200 p-4 text-sm font-medium text-gray-600 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] z-10">
                    <div class="flex justify-between items-center">
                        <div class="flex gap-8">
                            <div class="flex flex-col">
                                <span class="text-[10px] uppercase text-gray-400 font-bold tracking-wider">Items</span>
                                <span class="text-xl font-bold text-gray-800" x-text="cart.length">0</span>
                            </div>
                             <div class="flex flex-col">
                                <span class="text-[10px] uppercase text-gray-400 font-bold tracking-wider">Qty</span>
                                <span class="text-xl font-bold text-gray-800" x-text="cart.reduce((acc, item) => acc + item.qty, 0)">0</span>
                            </div>
                        </div>
                        <div class="flex gap-12 text-right items-end">
                             <div class="flex flex-col gap-0.5">
                                 <span class="text-[10px] uppercase text-gray-400 font-bold tracking-wider">Subtotal</span>
                                 <span class="text-base font-bold text-gray-700" x-text="'Rp ' + formatNumber(subTotal)">Rp 0</span>
                             </div>
                             <!-- Moved Discount Here -->
                             <div class="flex flex-col gap-0.5">
                                 <span class="text-[10px] uppercase text-gray-400 font-bold tracking-wider">Diskon (5%)</span>
                                 <span class="text-base font-bold text-red-500" x-show="discountAmount > 0" x-text="'- Rp ' + formatNumber(discountAmount)"></span>
                                 <span class="text-base font-bold text-gray-400" x-show="discountAmount === 0">Rp 0</span>
                             </div>
                             <div class="flex flex-col gap-0.5">
                                 <span class="text-[10px] uppercase text-gray-400 font-bold tracking-wider">Pajak (0%)</span>
                                 <span class="text-base font-bold text-gray-700">Rp 0</span>
                             </div>
                             <div class="flex flex-col gap-0.5 pl-6 border-l border-gray-200">
                                 <span class="text-[10px] uppercase text-[#4F46E5] font-bold tracking-wider">Total Akhir</span>
                                 <span class="text-2xl font-extrabold text-[#4F46E5]" x-text="'Rp ' + formatNumber(cartTotal)">Rp 0</span>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Size Modal (Updated Visuals) -->
        <div x-show="showSizeModal" class="fixed inset-0 z-[60] flex items-center justify-center p-4" style="display: none;">
             <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-md transition-opacity" @click="showSizeModal = false"></div>
             <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden border border-gray-100 transform transition-all">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-xl font-extrabold text-gray-900" x-text="selectedProduct?.name"></h3>
                         <button @click="showSizeModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                        </button>
                    </div>
                    <p class="text-[#4F46E5] font-bold text-base mb-4" x-text="'Rp ' + (selectedProduct?.price || 0).toLocaleString('id-ID')"></p>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Pilih Ukuran</label>
                            <div class="grid grid-cols-4 gap-2">
                                <template x-for="size in ['S', 'M', 'L', 'XL', 'XXL']">
                                    <button @click="selectedSize = size" 
                                            class="py-2.5 rounded-lg border text-sm font-bold transition-all" 
                                            :class="selectedSize === size ? 'border-[#4F46E5] bg-[#4F46E5] text-white shadow-md' : 'border-gray-200 text-gray-500 hover:border-[#4F46E5] hover:text-[#4F46E5]'"
                                            x-text="size">
                                    </button>
                                </template>
                            </div>
                        </div>
                           <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">Jumlah Item</label>
                            <div class="flex items-center gap-3">
                                <button @click="qty > 1 ? qty-- : null" class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center text-gray-600 hover:bg-gray-200 transition-colors border border-gray-200 font-bold text-lg">-</button>
                                <input type="number" x-model="qty" class="flex-1 text-center border border-gray-200 rounded-lg h-10 focus:border-[#4F46E5] focus:ring-0 font-bold text-lg text-gray-800" readonly>
                                <button @click="qty++" class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center text-gray-600 hover:bg-gray-200 transition-colors border border-gray-200 font-bold text-lg">+</button>
                            </div>
                        </div>
                    </div>
                     <div class="mt-6">
                        <button @click="addToCart" class="w-full py-3 rounded-lg bg-[#4F46E5] text-white font-bold text-sm shadow-lg shadow-indigo-500/30 hover:bg-[#4338ca] hover:shadow-xl transition-all flex items-center justify-center gap-2 transform active:scale-95">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                            Tambah
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Logic -->
    <script>
        function posData() {
            return {
                showProductModal: false,
                showSizeModal: false,
                selectedProduct: null,
                selectedSize: null,
                searchQuery: '',
                qty: 1,
                
                // Real DB Data
                products: @json($products).map(p => ({
                    ...p,
                    price: Number(p.price), // Force number type for logic
                    // Map category/id to visual styles if needed, or keep generic
                    bgClass: 'bg-indigo-50', 
                    textClass: 'text-indigo-500' 
                })),

                cart: [],
                
                get subTotal() {
                    return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
                },

                get discountAmount() {
                    if (this.subTotal > 250000) {
                        return this.subTotal * 0.05;
                    }
                    return 0;
                },

                get cartTotal() {
                    return this.subTotal - this.discountAmount;
                },

                get filteredProducts() {
                    if (this.searchQuery === '') return this.products;
                    return this.products.filter(product => {
                        return product.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                               product.category.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                               product.code.toLowerCase().includes(this.searchQuery.toLowerCase());
                    });
                },

                handleSearch() {
                    if (this.searchQuery.length > 0) {
                        this.showProductModal = true;
                    } else {
                        this.showProductModal = false;
                    }
                },

                openSizeModal(product) {
                    this.selectedProduct = product;
                    this.selectedSize = 'M';
                    this.qty = 1;
                    this.showProductModal = false; 
                    this.searchQuery = ''; // Clear search on selection
                    this.showSizeModal = true;
                },

                addToCart() {
                    if (!this.selectedSize) return alert('Pilih ukuran!');
                    
                    // Add ID to cart item for backend validation
                    this.cart.push({
                        id: this.selectedProduct.id, 
                        name: this.selectedProduct.name,
                        category: this.selectedProduct.category,
                        price: Number(this.selectedProduct.price), // Ensure number
                        qty: this.qty,
                        size: this.selectedSize
                    });
                    this.showSizeModal = false;
                },

                removeItem(index) {
                    this.cart.splice(index, 1);
                },

                resetCart() {
                    if(confirm('Hapus semua item?')) this.cart = [];
                },
                
                async submitTransaction() {
                    if (this.cart.length === 0) return alert('Keranjang kosong!');
                    if (!confirm('Proses pembayaran?')) return;

                    try {
                        const response = await fetch('{{ url("/transactions") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                cart: this.cart,
                                total_amount: this.cartTotal,
                                paid_amount: this.cartTotal // Assuming exact payment for now
                            })
                        });

                        const result = await response.json();

                        if (response.ok) {
                            alert('Transaksi Berhasil! Total: Rp ' + this.formatNumber(this.cartTotal));
                            this.cart = [];
                        } else {
                            alert('Gagal: ' + result.message);
                        }
                    } catch (error) {
                        console.error(error);
                        alert('Terjadi kesalahan sistem.');
                    }
                },

                formatNumber(num) {
                    return new Intl.NumberFormat('id-ID').format(num);
                }
            }
        }
    </script>
@endsection
