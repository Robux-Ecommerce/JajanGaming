<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class BrowseController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)
            ->where('game_name', 'Roblox');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $category = $request->category;
            
            if ($category === 'popular') {
                $query->where('rating', '>=', 4.5);
            } elseif ($category === 'top_seller') {
                $query->where('sales_count', '>=', 50);
            } elseif ($category === 'new_releases') {
                $query->where('created_at', '>=', now()->subDays(30));
            }
        }

        // Filter by price range
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by game type
        if ($request->has('game_type') && $request->game_type) {
            $query->where('game_type', $request->game_type);
        }

        // Sort functionality
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'popular':
                $query->orderBy('rating', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->with('seller')->paginate(12);
        
        // Get available game types for filter
        $gameTypes = Product::where('is_active', true)
            ->where('game_name', 'Roblox')
            ->distinct()
            ->pluck('game_type');

        return view('browse', compact('products', 'gameTypes'));
    }
}
