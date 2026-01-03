@extends('layouts.app')

@section('title', 'Dashboard')
@section('header_title', 'Ringkasan Bisnis')

@section('content')
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Card 1: Sales -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Penjualan Hari Ini</p>
                    <h3 class="text-2xl font-bold text-gray-900">Rp {{ number_format($todaySales, 0, ',', '.') }}</h3>
                    <div class="flex items-center mt-2 text-sm font-medium {{ $salesChange >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="{{ $salesChange >= 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6' }}"></path>
                        </svg>
                        <span>{{ $salesChange >= 0 ? '+' : '' }}{{ number_format($salesChange, 1) }}% dari kemarin</span>
                    </div>
                </div>
                <div class="p-3 bg-indigo-50 rounded-xl text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23" />
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 2: Orders -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Pesanan Hari Ini</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ number_format($todayOrders) }}</h3>
                    <div class="flex items-center mt-2 text-sm font-medium {{ $orderDiff >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="{{ $orderDiff >= 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6' }}"></path>
                        </svg>
                        <span>{{ $orderDiff >= 0 ? '+' : '' }}{{ $orderDiff }} dari kemarin</span>
                    </div>
                </div>
                <div class="p-3 bg-emerald-50 rounded-xl text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z" />
                        <path d="M3 6h18" />
                        <path d="M16 10a4 4 0 0 1-8 0" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid: Transactions & Low Stock -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Recent Transactions (Left, 2 Cols) -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden h-fit">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800">Transaksi Terbaru</h2>
                <a href="{{ url('/reports') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">ID Pesanan</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kasir</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Item</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Total</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentTransactions as $trx)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-mono font-bold text-[#4F46E5]">#TRX-{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $trx->cashier_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $trx->items_count }} Item</td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-900 text-right">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 text-center">
                                 {{ \Carbon\Carbon::parse($trx->created_at)->diffForHumans() }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 text-sm">Belum ada transaksi hari ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Low Stock Widget (Right, 1 Col) -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow h-fit">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Stok Menipis</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ count($lowStockItems) }} Item</h3>
                </div>
                <div class="p-3 bg-red-50 rounded-xl text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                        <path d="M12 9v4" />
                        <path d="M12 17h.01" />
                    </svg>
                </div>
            </div>
            
            <div class="flex flex-col gap-3">
                @forelse($lowStockItems as $item)
                    <div class="flex items-center justify-between border-b border-gray-50 last:border-0 pb-2 last:pb-0">
                        <div class="flex items-center gap-3">
                            <!-- Image/Placeholder -->
                            <div class="shrink-0">
                                @if($item->image)
                                    <img src="{{ asset('uploads/products/' . $item->image) }}" class="w-10 h-10 rounded-lg object-cover bg-gray-100" alt="{{ $item->name }}">
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 font-bold text-xs">
                                        {{ substr($item->name, 0, 2) }}
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Info -->
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-bold text-gray-800 truncate" title="{{ $item->name }}">{{ $item->name }}</h4>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @foreach(['s', 'm', 'l', 'xl', 'xxl'] as $size)
                                        @php $stockKey = 'stock_' . $size; @endphp
                                        @if($item->$stockKey < 5)
                                            <span class="text-[10px] px-1.5 py-0.5 rounded bg-red-100 text-red-700 font-bold uppercase whitespace-nowrap">{{ $size }}: {{ $item->$stockKey }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6">
                        <p class="text-sm text-gray-400 italic">Semua stok aman.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
@endsection