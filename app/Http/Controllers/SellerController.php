<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SellerController extends Controller
{
    // Dashboard seller
    public function dashboard()
    {
        $seller = auth()->user();
        
        // Get seller's product IDs - use seller_name if seller_id column doesn't exist yet
        $sellerProductIds = Product::where(function($query) use ($seller) {
            if (Schema::hasColumn('products', 'seller_id')) {
                $query->where('seller_id', $seller->id);
            } else {
                $query->where('seller_name', $seller->name);
            }
        })->pluck('id');
        
        // Get orders that contain seller's products
        $sellerOrderIds = OrderItem::whereIn('product_id', $sellerProductIds)
            ->pluck('order_id')
            ->unique();
        
        $sellerOrders = Order::whereIn('id', $sellerOrderIds);
        
        // Calculate revenue from order items of seller's products
        $totalRevenue = OrderItem::whereIn('product_id', $sellerProductIds)
            ->whereHas('order', function($query) {
                $query->where('status', 'completed');
            })
            ->sum(DB::raw('quantity * price'));
        
        // Stats untuk seller
        $totalProductsQuery = Product::where(function($query) use ($seller) {
            if (Schema::hasColumn('products', 'seller_id')) {
                $query->where('seller_id', $seller->id);
            } else {
                $query->where('seller_name', $seller->name);
            }
        });
        
        // Calculate average rating for seller's products
        $sellerProducts = $totalProductsQuery->get();
        $averageRating = $sellerProducts->count() > 0 
            ? $sellerProducts->avg('rating') ?? 0 
            : 0;
        
        // Calculate total ratings count
        $totalRatings = Rating::whereIn('product_id', $sellerProductIds)->count();
        
        // Calculate customer satisfaction (percentage of 4-5 star ratings)
        $satisfactionRatings = Rating::whereIn('product_id', $sellerProductIds)
            ->whereIn('rating', [4, 5])
            ->count();
        $customerSatisfaction = $totalRatings > 0 
            ? round(($satisfactionRatings / $totalRatings) * 100, 1) 
            : 0;
        
        // Calculate unique customers
        $uniqueCustomers = Order::whereIn('id', $sellerOrderIds)
            ->distinct('user_id')
            ->count('user_id');
        
        // Calculate average order value
        $avgOrderValue = $sellerOrders->where('status', 'completed')->distinct()->count() > 0
            ? round($totalRevenue / max($sellerOrders->where('status', 'completed')->distinct()->count(), 1), 0)
            : 0;
        
        // Calculate products by game type for chart
        $productsByGameType = Product::whereIn('id', $sellerProductIds)
            ->select('game_type', DB::raw('COUNT(*) as count'))
            ->groupBy('game_type')
            ->get();
        
        $stats = [
            'total_products' => $totalProductsQuery->count(),
            'total_orders' => $sellerOrders->distinct()->count(),
            'total_revenue' => $totalRevenue ?: $seller->wallet_balance ?? 0,
            'pending_orders' => $sellerOrders->where('status', 'pending')->distinct()->count(),
            'completed_orders' => $sellerOrders->where('status', 'completed')->distinct()->count(),
            'cancelled_orders' => $sellerOrders->where('status', 'cancelled')->distinct()->count(),
            'average_rating' => round($averageRating, 1),
            'total_ratings' => $totalRatings,
            'customer_satisfaction' => $customerSatisfaction,
            'unique_customers' => $uniqueCustomers,
            'avg_order_value' => $avgOrderValue,
        ];

        // Recent orders (that contain seller's products)
        $recent_orders = Order::whereIn('id', $sellerOrderIds)
            ->with(['user', 'orderItems.product'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Top selling products (seller's products)
        $top_products = Product::where(function($query) use ($seller) {
            if (Schema::hasColumn('products', 'seller_id')) {
                $query->where('seller_id', $seller->id);
            } else {
                $query->where('seller_name', $seller->name);
            }
        })
            ->orderBy('sales_count', 'desc')
            ->limit(5)
            ->get();

        // Monthly revenue chart data (from seller's products)
        $monthly_revenue = OrderItem::select(
                DB::raw('MONTH(orders.created_at) as month'),
                DB::raw('SUM(order_items.quantity * order_items.price) as revenue')
            )
            ->whereIn('order_items.product_id', $sellerProductIds)
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->whereYear('orders.created_at', date('Y'))
            ->groupBy('month')
            ->get();

        // Monthly orders count (completed, containing seller's products)
        $monthly_orders = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(DISTINCT orders.id) as orders_count')
            )
            ->whereIn('id', $sellerOrderIds)
            ->where('status', 'completed')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get();

        $user = $seller;

        return view('seller.dashboard', compact('seller', 'stats', 'recent_orders', 'top_products', 'monthly_revenue', 'monthly_orders', 'user', 'productsByGameType'));
    }

    // Orders seller
    public function orders()
    {
        $seller = auth()->user();
        
        // Get seller's products using seller_name if seller_id doesn't exist
        $sellerProducts = Product::where(function($query) use ($seller) {
            if (Schema::hasColumn('products', 'seller_id')) {
                $query->where('seller_id', $seller->id);
            } else {
                $query->where('seller_name', $seller->name);
            }
        })->with('orderItems')->paginate(10);
        
        return view('seller.orders', compact('sellerProducts'));
    }

    // Transactions seller - detail transaksi dengan informasi pemesanan
    public function transactions()
    {
        $seller = auth()->user();
        
        // Get seller's product IDs
        $sellerProductIds = Product::where(function($query) use ($seller) {
            if (Schema::hasColumn('products', 'seller_id')) {
                $query->where('seller_id', $seller->id);
            } else {
                $query->where('seller_name', $seller->name);
            }
        })->pluck('id');
        
        // Get orders that contain seller's products
        $sellerOrderIds = OrderItem::whereIn('product_id', $sellerProductIds)
            ->pluck('order_id')
            ->unique();
        
        // Get orders with details
        $orders = Order::whereIn('id', $sellerOrderIds)
            ->with(['user', 'orderItems.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        // Calculate stats
        $totalRevenue = OrderItem::whereIn('product_id', $sellerProductIds)
            ->whereHas('order', function($query) {
                $query->where('status', 'completed');
            })
            ->sum(DB::raw('quantity * price'));
        
        $stats = [
            'total_orders' => $orders->total(),
            'completed_orders' => Order::whereIn('id', $sellerOrderIds)
                ->where('status', 'completed')
                ->count(),
            'pending_orders' => Order::whereIn('id', $sellerOrderIds)
                ->where('status', 'pending')
                ->count(),
            'total_revenue' => $totalRevenue,
        ];
        
        return view('seller.transactions', compact('seller', 'orders', 'stats'));
    }

    // Wallet seller
    public function wallet()
    {
        $seller = auth()->user();
        
        // Get seller's product IDs
        $sellerProductIds = Product::where(function($query) use ($seller) {
            if (Schema::hasColumn('products', 'seller_id')) {
                $query->where('seller_id', $seller->id);
            } else {
                $query->where('seller_name', $seller->name);
            }
        })->pluck('id');
        
        // Get orders that contain seller's products
        $sellerOrderIds = OrderItem::whereIn('product_id', $sellerProductIds)
            ->pluck('order_id')
            ->unique();
        
        // Calculate total revenue from completed orders
        $totalRevenue = OrderItem::whereIn('product_id', $sellerProductIds)
            ->whereHas('order', function($query) {
                $query->where('status', 'completed');
            })
            ->sum(DB::raw('quantity * price'));
        
        // Get recent completed orders for transaction history
        $recentTransactions = Order::whereIn('id', $sellerOrderIds)
            ->where('status', 'completed')
            ->with(['user', 'orderItems.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Pass as user so view recognizes it
        $user = $seller;
        
        return view('wallet.index', compact('user', 'recentTransactions', 'totalRevenue'));
    }

    // Profile seller
    public function profile()
    {
        $seller = auth()->user();
        return view('seller.profile', compact('seller'));
    }

    // Update profile seller
    public function updateProfile(Request $request)
    {
        $seller = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $seller->id,
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $seller->update($validated);

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profiles', 'public');
            $seller->update(['profile_photo' => $path]);
        }

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    // Change password seller
    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        auth()->user()->update([
            'password' => bcrypt($validated['password']),
        ]);

        return back()->with('success', 'Kata sandi berhasil diubah!');
    }
}
