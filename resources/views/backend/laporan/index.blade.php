@extends('layouts.app')

@section('title', 'Laporan')
@section('header_title', 'Laporan Penjualan')

@section('content')
    <div class="space-y-6">
        <!-- Filters & Actions -->
        <form action="{{ url('/reports') }}" method="GET"
            class="flex flex-col md:flex-row gap-4 justify-between items-end md:items-center bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center gap-4 flex-1">
                <div class="relative w-full md:w-auto">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Dari Tanggal</label>
                    <div class="relative">
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm font-medium focus:ring-2 focus:ring-[#C6DCE4] focus:border-[#C6DCE4] outline-none">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="relative w-full md:w-auto">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Sampai Tanggal</label>
                    <div class="relative">
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm font-medium focus:ring-2 focus:ring-[#C6DCE4] focus:border-[#C6DCE4] outline-none">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <button type="submit"
                    class="px-5 py-2 mt-5 bg-[#4F46E5] hover:bg-[#4338ca] text-white rounded-lg text-sm font-bold shadow-lg shadow-indigo-500/20 transition-all">
                    Tampilkan
                </button>
            </div>

            <div class="flex items-center gap-2">
                @if(request('start_date') || request('end_date'))
                    <a href="{{ url('/reports') }}"
                        class="px-4 py-2 bg-white border border-red-200 text-red-600 hover:bg-red-50 rounded-lg text-sm font-bold transition-all">
                        Reset Filter
                    </a>
                @endif
            </div>
        </form>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card 1 -->
            <div class="bg-gradient-to-br from-[#FFE6E6] to-white p-6 rounded-2xl shadow-sm border border-[#F2D1D1]">
                <div class="flex items-center gap-4 mb-2">
                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-[#F2D1D1] shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="1" x2="12" y2="23" />
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-500 uppercase">Total Omset</span>
                </div>
                <h3 class="text-3xl font-extrabold text-gray-800">Rp {{ number_format($totalOmset, 0, ',', '.') }}</h3>
                <p class="text-xs text-gray-400 font-semibold mt-1">
                    {{ request('start_date') ? 'Periode terpilih' : 'Semua waktu' }}
                </p>
            </div>

            <!-- Card 2 -->
            <div class="bg-gradient-to-br from-[#DAEAF1] to-white p-6 rounded-2xl shadow-sm border border-[#C6DCE4]">
                <div class="flex items-center gap-4 mb-2">
                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-[#C6DCE4] shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z" />
                            <path d="M3 6h18" />
                            <path d="M16 10a4 4 0 0 1-8 0" />
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-500 uppercase">Total Transaksi</span>
                </div>
                <h3 class="text-3xl font-extrabold text-gray-800">{{ number_format($totalTransactions) }}</h3>
                <p class="text-xs text-gray-400 font-semibold mt-1">Transaksi berhasil</p>
            </div>

            <!-- Card 3 -->
            <div class="bg-gradient-to-br from-[#FFF8E1] to-white p-6 rounded-2xl shadow-sm border border-[#FFE082]">
                <div class="flex items-center gap-4 mb-2">
                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-[#FFC107] shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M20.38 3.4a2 2 0 0 0-2.83 0L5 15.94a2 2 0 0 0-.55.9l-1 5a1 1 0 0 0 1.2 1.2l5-1a2 2 0 0 0 .9-.55L20.38 6.23a2 2 0 0 0 0-2.83Z" />
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-500 uppercase">Item Terjual</span>
                </div>
                <h3 class="text-3xl font-extrabold text-gray-800">{{ number_format($itemsSold) }}</h3>
                <p class="text-xs text-gray-400 font-semibold mt-1">Pcs</p>
            </div>
        </div>

        <!-- Latest Transactions Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Riwayat Penjualan</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">No. Faktur
                            </th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kasir</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Metode</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">
                                Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($transactions as $trx)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-mono font-bold text-[#4F46E5]">
                                    #TRX-{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 font-medium">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-[10px] font-bold text-gray-600">
                                            {{ substr($trx->cashier_name, 0, 2) }}
                                        </div>
                                        {{ $trx->cashier_name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 capitalize">{{ $trx->payment_method }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-900 text-right">
                                    Rp {{ number_format($trx->total_amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500 text-sm">
                                    Belum ada data transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="p-4 border-t border-gray-100">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
@endsection