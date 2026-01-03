<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $user = auth()->user();

        // Helper to apply role scope
        $applyScope = function ($query) use ($user) {
            if ($user->role !== 'admin') {
                $query->where('user_id', $user->id);
            }
        };

        // 1. Sales Stats (Today vs Yesterday)
        $todaySales = DB::table('transactions')
            ->whereDate('created_at', $today)
            ->where(function ($q) use ($applyScope) {
                $applyScope($q); })
            ->sum('total_amount');

        $yesterdaySales = DB::table('transactions')
            ->whereDate('created_at', $yesterday)
            ->where(function ($q) use ($applyScope) {
                $applyScope($q); })
            ->sum('total_amount');

        $salesChange = 0;
        if ($yesterdaySales > 0) {
            $salesChange = (($todaySales - $yesterdaySales) / $yesterdaySales) * 100;
        } else {
            $salesChange = $todaySales > 0 ? 100 : 0;
        }

        // 2. Order Stats
        $todayOrders = DB::table('transactions')
            ->whereDate('created_at', $today)
            ->where(function ($q) use ($applyScope) {
                $applyScope($q); })
            ->count();

        $yesterdayOrders = DB::table('transactions')
            ->whereDate('created_at', $yesterday)
            ->where(function ($q) use ($applyScope) {
                $applyScope($q); })
            ->count();

        $orderDiff = $todayOrders - $yesterdayOrders;

        // 3. Low Stock (Global for everyone, as staff needs to know stock too)
        $lowStockItems = DB::table('products')
            ->where(function ($query) {
                $query->where('stock_s', '<', 5)
                    ->orWhere('stock_m', '<', 5)
                    ->orWhere('stock_l', '<', 5)
                    ->orWhere('stock_xl', '<', 5)
                    ->orWhere('stock_xxl', '<', 5);
            })
            ->limit(5)
            ->get();

        // 4. Recent Transactions
        $recentQuery = DB::table('transactions')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->select('transactions.*', 'users.name as cashier_name')
            ->orderBy('transactions.created_at', 'desc');

        if ($user->role !== 'admin') {
            $recentQuery->where('transactions.user_id', $user->id);
        }

        $recentTransactions = $recentQuery->limit(5)->get();

        // Calculate items count for recent transactions efficiently
        // Or just let it be if we didn't store item count in transactions table (we didn't).
        // We can do a quick subquery or just show "Details" in view?
        // View shows "Items". Let's fetch details count for these 5 IDs.
        foreach ($recentTransactions as $trx) {
            $trx->items_count = DB::table('transaction_details')
                ->where('transaction_id', $trx->id)
                ->sum('quantity');
        }

        return view('backend.dashboard.index', compact(
            'todaySales',
            'salesChange',
            'todayOrders',
            'orderDiff',
            'lowStockItems',
            'recentTransactions'
        ));
    }
}
