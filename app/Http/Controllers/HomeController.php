<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Redirect seller to admin dashboard
        if (auth()->check() && auth()->user()->isSeller()) {
            return redirect()->route('admin.dashboard');
        }

        $query = Product::where('is_active', true);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('game_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by game (default to Roblox)
        if ($request->has('game') && $request->get('game')) {
            $query->where('game_name', $request->get('game'));
        } else {
            // Default to Roblox if no game filter
            $query->where('game_name', 'Roblox');
        }

        // Filter by category
        if ($request->has('category')) {
            $category = $request->get('category');
            
            if ($category === 'popular') {
                // Game popular berdasarkan rating tertinggi
                $query->orderBy('rating', 'desc');
            } elseif ($category === 'top_seller') {
                // Penjualan terbanyak berdasarkan sales_count tertinggi
                $query->orderBy('sales_count', 'desc');
            }
        } else {
            // Default ordering
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->with('seller')->paginate(12);
        $games = Product::distinct()->pluck('game_name');
        
        // Get top selling products (best sellers)
        $topSellingProducts = Product::where('is_active', true)
            ->where('game_name', 'Roblox')
            ->with('seller')
            ->orderBy('sales_count', 'desc')
            ->take(4)
            ->get();

        return view('home', compact('products', 'games', 'topSellingProducts'));
    }

    public function showProduct(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
