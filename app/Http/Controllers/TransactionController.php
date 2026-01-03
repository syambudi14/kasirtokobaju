<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function index()
    {
        // Load all products for the JS search
        // In a real large app, you'd want to paginate or search via AJAX.
        $products = Product::all();
        return view('backend.cashier.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'required|exists:products,id',
            'cart.*.qty' => 'required|integer|min:1',
            'cart.*.size' => 'required|string|in:S,M,L,XL,XXL',
            'paid_amount' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $grossTotal = 0;
            $processedItems = [];

            // 1. Prepare Items & Calculate Gross Total
            foreach ($request->cart as $item) {
                $product = Product::lockForUpdate()->find($item['id']);

                // Stock Check
                $sizeColumn = 'stock_' . strtolower($item['size']);
                if ($product->$sizeColumn < $item['qty']) {
                    throw new \Exception("Stok tidak cukup untuk {$product->name} ({$item['size']})");
                }

                $price = (float) $product->price;
                $subtotal = $price * $item['qty'];
                $grossTotal += $subtotal;

                $processedItems[] = [
                    'product' => $product,
                    'size' => $item['size'],
                    'qty' => $item['qty'],
                    'price' => $price,
                    'subtotal' => $subtotal,
                    'sizeColumn' => $sizeColumn
                ];
            }

            // 2. Apply Global Discount
            $discountAmount = 0;
            if ($grossTotal > 250000) {
                $discountAmount = $grossTotal * 0.05;
            }
            $netTotal = $grossTotal - $discountAmount;

            // 3. Create Transaction Header
            $transactionId = DB::table('transactions')->insertGetId([
                'user_id' => auth()->id(),
                'total_amount' => $netTotal, // Saving the Net Amount
                'paid_amount' => $request->paid_amount,
                'change_amount' => $request->paid_amount - $netTotal,
                'payment_method' => 'cash',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 4. Deduction & Details Insertion
            foreach ($processedItems as $item) {
                // Deduct Stock
                $item['product']->decrement($item['sizeColumn'], $item['qty']);
                $item['product']->decrement('total_stock', $item['qty']);

                // Insert Detail
                DB::table('transaction_details')->insert([
                    'transaction_id' => $transactionId,
                    'product_id' => $item['product']->id,
                    'size' => $item['size'],
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'], // Saving original subtotal
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil!',
                'transaction_id' => $transactionId
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
