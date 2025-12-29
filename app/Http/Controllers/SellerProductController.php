<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SellerProductController extends Controller
{
    // List semua produk milik seller
    public function index()
    {
        $seller = auth()->user();
        
        // Get seller's products using seller_name if seller_id doesn't exist
        $products = Product::where(function($query) use ($seller) {
            if (Schema::hasColumn('products', 'seller_id')) {
                $query->where('seller_id', $seller->id);
            } else {
                $query->where('seller_name', $seller->name);
            }
        })->paginate(10);
        
        return view('seller.products.index', compact('products'));
    }

    // Form tambah produk baru
    public function create()
    {
        return view('seller.products.create');
    }

    // Store produk baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'game_name' => 'required|string|max:255',
            'game_type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $seller = auth()->user();
        
        // Add seller info to product data
        if (Schema::hasColumn('products', 'seller_id')) {
            $validated['seller_id'] = $seller->id;
        } else {
            $validated['seller_name'] = $seller->name;
        }
        
        // Map stock to quantity
        $validated['quantity'] = $validated['stock'];
        unset($validated['stock']);
        
        $product = Product::create($validated);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->update(['image' => $path]);
        }

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    // Form edit produk
    public function edit(Product $product)
    {
        $seller = auth()->user();
        // Verify product belongs to seller
        if (Schema::hasColumn('products', 'seller_id')) {
            if ($product->seller_id != $seller->id) {
                abort(403, 'Unauthorized');
            }
        } else {
            if ($product->seller_name != $seller->name) {
                abort(403, 'Unauthorized');
            }
        }
        return view('seller.products.edit', compact('product'));
    }

    // Update produk
    public function update(Request $request, Product $product)
    {
        $seller = auth()->user();
        // Verify product belongs to seller
        if (Schema::hasColumn('products', 'seller_id')) {
            if ($product->seller_id != $seller->id) {
                abort(403, 'Unauthorized');
            }
        } else {
            if ($product->seller_name != $seller->name) {
                abort(403, 'Unauthorized');
            }
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'game_name' => 'required|string|max:255',
            'game_type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Map stock to quantity
        $validated['quantity'] = $validated['stock'];
        unset($validated['stock']);

        $product->update($validated);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->update(['image' => $path]);
        }

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    // Delete produk
    public function destroy(Product $product)
    {
        $seller = auth()->user();
        // Verify product belongs to seller
        if (Schema::hasColumn('products', 'seller_id')) {
            if ($product->seller_id != $seller->id) {
                abort(403, 'Unauthorized');
            }
        } else {
            if ($product->seller_name != $seller->name) {
                abort(403, 'Unauthorized');
            }
        }
        $product->delete();

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
