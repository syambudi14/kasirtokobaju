<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%")
                ->orWhere('category', 'like', "%{$search}%");
        }

        $products = $query->latest()->get();
        return view('backend.products.index', compact('products'));
    }

    public function create()
    {
        return view('backend.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255|unique:products,name',
            'code' => 'required|string|unique:products,code',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'stock_s' => 'nullable|integer|min:0',
            'stock_m' => 'nullable|integer|min:0',
            'stock_l' => 'nullable|integer|min:0',
            'stock_xl' => 'nullable|integer|min:0',
            'stock_xxl' => 'nullable|integer|min:0',
        ]);

        // Calculate Total Stock
        $totalStock =
            ($request->stock_s ?? 0) +
            ($request->stock_m ?? 0) +
            ($request->stock_l ?? 0) +
            ($request->stock_xl ?? 0) +
            ($request->stock_xxl ?? 0);

        // Validation: Ensure total stock is at least 2
        if ($totalStock < 2) {
            return back()->with('error', 'Total stok produk awal minimal harus 2 pcs (gabungan semua ukuran).')->withInput();
        }

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $path = public_path('uploads/products');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move($path, $imageName);
            $validated['image'] = $imageName;
        }

        $validated['total_stock'] = $totalStock;

        // Fill default 0 for null stocks
        $validated['stock_s'] = $request->stock_s ?? 0;
        $validated['stock_m'] = $request->stock_m ?? 0;
        $validated['stock_l'] = $request->stock_l ?? 0;
        $validated['stock_xl'] = $request->stock_xl ?? 0;
        $validated['stock_xxl'] = $request->stock_xxl ?? 0;

        Product::create($validated);

        return redirect('/products')->with('success', 'Produk berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete image if exists
        if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {
            unlink(public_path('uploads/products/' . $product->image));
        }

        $product->delete();
        return redirect('/products')->with('success', 'Produk berhasil dihapus');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('backend.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255|unique:products,name,' . $id,
            'code' => 'required|string|unique:products,code,' . $id,
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'stock_s' => 'nullable|integer|min:0',
            'stock_m' => 'nullable|integer|min:0',
            'stock_l' => 'nullable|integer|min:0',
            'stock_xl' => 'nullable|integer|min:0',
            'stock_xxl' => 'nullable|integer|min:0',
        ]);

        // Calculate Total Stock
        $totalStock =
            ($request->stock_s ?? 0) +
            ($request->stock_m ?? 0) +
            ($request->stock_l ?? 0) +
            ($request->stock_xl ?? 0) +
            ($request->stock_xxl ?? 0);

        // Validation: Ensure total stock is at least 2
        if ($totalStock < 2) {
            return back()->with('error', 'Total stok produk minimal harus 2 pcs (gabungan semua ukuran).')->withInput();
        }

        // Handle Image Upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {
                unlink(public_path('uploads/products/' . $product->image));
            }

            $path = public_path('uploads/products');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move($path, $imageName);
            $validated['image'] = $imageName;
        }

        $validated['total_stock'] = $totalStock;

        // Fill default 0 for null stocks
        $validated['stock_s'] = $request->stock_s ?? 0;
        $validated['stock_m'] = $request->stock_m ?? 0;
        $validated['stock_l'] = $request->stock_l ?? 0;
        $validated['stock_xl'] = $request->stock_xl ?? 0;
        $validated['stock_xxl'] = $request->stock_xxl ?? 0;

        $product->update($validated);

        return redirect('/products')->with('success', 'Produk berhasil diperbarui');
    }

    public function addStock(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
            'size' => 'required|string',
        ]);

        $product = Product::findOrFail($id);
        $size = strtolower($request->size); // s, m, l, xl, xxl
        $qty = $request->qty;

        $column = "stock_{$size}";

        if (in_array($column, ['stock_s', 'stock_m', 'stock_l', 'stock_xl', 'stock_xxl'])) {
            $product->increment($column, $qty);
            $product->calculateTotalStock();
            return back()->with('success', 'Stok berhasil ditambahkan');
        }

        return back()->with('error', 'Ukuran tidak valid');
    }
}
