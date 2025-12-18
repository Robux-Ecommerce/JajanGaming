<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Check if user is admin or seller
        if (!auth()->user()->isAdminOrSeller()) {
            abort(403, 'Unauthorized access');
        }

        $user = auth()->user();
        
        if ($user->isAdmin()) {
            // Admin sees all data
            $stats = [
                'total_products' => Product::count(),
                'total_orders' => Order::count(),
                'total_users' => User::where('role', 'user')->count(),
                'total_revenue' => Order::where('status', 'completed')->sum('total_amount'),
                'pending_orders' => Order::where('status', 'pending')->count(), 
                'completed_orders' => Order::where('status', 'completed')->count(),
                'cancelled_orders' => Order::where('status', 'cancelled')->count(),
            ];

            // Recent orders
            $recent_orders = Order::with(['user', 'orderItems.product'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Top selling products
            $top_products = Product::orderBy('sales_count', 'desc')
                ->limit(5)
                ->get();

            // Monthly revenue chart data
            $monthly_revenue = Order::select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('SUM(total_amount) as revenue')
                )
                ->where('status', 'completed')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->get();

            // Monthly orders count (completed)
            $monthly_orders = Order::select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('COUNT(*) as orders_count')
                )
                ->where('status', 'completed')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->get();
        } else {
            // Seller sees only their data
            $stats = [
                'total_products' => Product::where('seller_name', $user->name)->count(),
                'total_orders' => Order::whereHas('orderItems.product', function($query) use ($user) {
                    $query->where('seller_name', $user->name);
                })->count(),
                'total_users' => 0, // Sellers don't see user count
                'total_revenue' => Order::whereHas('orderItems.product', function($query) use ($user) {
                    $query->where('seller_name', $user->name);
                })->where('status', 'completed')->sum('total_amount'),
                'pending_orders' => Order::whereHas('orderItems.product', function($query) use ($user) {
                    $query->where('seller_name', $user->name);
                })->where('status', 'pending')->count(), 
                'completed_orders' => Order::whereHas('orderItems.product', function($query) use ($user) {
                    $query->where('seller_name', $user->name);
                })->where('status', 'completed')->count(),
                'cancelled_orders' => Order::whereHas('orderItems.product', function($query) use ($user) {
                    $query->where('seller_name', $user->name);
                })->where('status', 'cancelled')->count(),
            ];

            // Recent orders for seller's products only
            $recent_orders = Order::whereHas('orderItems.product', function($query) use ($user) {
                $query->where('seller_name', $user->name);
            })->with(['user', 'orderItems.product'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Top selling products for seller only
            $top_products = Product::where('seller_name', $user->name)
                ->orderBy('sales_count', 'desc')
                ->limit(5)
                ->get();

            // Monthly revenue chart data for seller's products only
            $monthly_revenue = Order::whereHas('orderItems.product', function($query) use ($user) {
                $query->where('seller_name', $user->name);
            })->select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('SUM(total_amount) as revenue')
                )
                ->where('status', 'completed')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->get();

            // Monthly orders count for seller (completed)
            $monthly_orders = Order::whereHas('orderItems.product', function($query) use ($user) {
                $query->where('seller_name', $user->name);
            })->select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('COUNT(*) as orders_count')
                )
                ->where('status', 'completed')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->get();
        }

        return view('admin.dashboard', compact('stats', 'recent_orders', 'top_products', 'monthly_revenue', 'monthly_orders', 'user'));
    }

    public function products(Request $request)
    {
        // Check if user is admin or seller
        if (!auth()->user()->isAdminOrSeller()) {
            abort(403, 'Unauthorized access');
        }

        $user = auth()->user();
        $sellerId = $request->get('seller_id');
        
        if ($user->isAdmin()) {
            // If seller_id is provided, show products from that seller
            if ($sellerId) {
                $selectedSeller = User::where('id', $sellerId)
                    ->where('role', 'seller')
                    ->firstOrFail();
                
                $products = Product::where('seller_name', $selectedSeller->name)
                    ->with('orderItems')
                    ->orderBy('created_at', 'desc')
                    ->paginate(12);
                
                return view('admin.products.index', compact('products', 'user', 'selectedSeller'));
            }
            
            // Otherwise show list of sellers
            $sellers = User::where('role', 'seller')
                ->get()
                ->map(function($seller) {
                    $seller->total_sales = Product::where('seller_name', $seller->name)->sum('sales_count');
                    $seller->total_products = Product::where('seller_name', $seller->name)->count();
                    return $seller;
                })
                ->sortByDesc('total_sales');
            
            return view('admin.products.index', compact('user', 'sellers'));
        } else {
            // Seller sees only their products
            $products = Product::where('seller_name', $user->name)
                ->with('orderItems')
                ->orderBy('created_at', 'desc')
                ->paginate(12);
            
            $selectedSeller = $user;

            return view('admin.products.index', compact('products', 'user', 'selectedSeller'));
        }
    }

    public function createProduct()
    {
        // Check if user is admin or seller
        if (!auth()->user()->isAdminOrSeller()) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.products.create');
    }

    public function storeProduct(Request $request)
    {
        // Check if user is admin or seller
        if (!auth()->user()->isAdminOrSeller()) {
            abort(403, 'Unauthorized access');
        }

        $user = auth()->user();
        
        $validationRules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'game_name' => 'required|string|max:255',
            'game_type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'required|string|max:255',
            'image_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ];

        // Only require rating for admin
        if ($user->isAdmin()) {
            $validationRules['rating'] = 'required|numeric|min:0|max:5';
        }

        $request->validate($validationRules);

        $data = $request->all();
        
        // Handle image upload
        if ($request->hasFile('image_upload')) {
            $image = $request->file('image_upload');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('sellers', $imageName, 'public');
            $data['image'] = $imagePath;
        } else {
            // Use selected image from existing options
            $data['image'] = $request->image;
        }
        
        // Set seller info based on user role
        if ($user->isSeller()) {
            $data['seller_name'] = $user->name;
            $data['seller_photo'] = 'default_seller.jpg'; // Default photo
            $data['rating'] = 0; // Default rating for seller products
        }

        Product::create($data);

        return redirect()->route('admin.products')
            ->with('success', 'Product created successfully!');
    }

    public function editProduct(Product $product)
    {
        // Check if user is admin or seller
        if (!auth()->user()->isAdminOrSeller()) {
            abort(403, 'Unauthorized access');
        }

        $user = auth()->user();
        
        // If seller, check if product belongs to them
        if ($user->isSeller() && $product->seller_name !== $user->name) {
            abort(403, 'Unauthorized access. You can only edit your own products.');
        }

        return view('admin.products.edit', compact('product', 'user'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        // Check if user is admin or seller
        if (!auth()->user()->isAdminOrSeller()) {
            abort(403, 'Unauthorized access');
        }

        $user = auth()->user();
        
        // If seller, check if product belongs to them
        if ($user->isSeller() && $product->seller_name !== $user->name) {
            abort(403, 'Unauthorized access. You can only update your own products.');
        }

        $validationRules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'game_name' => 'required|string|max:255',
            'game_type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'required|string|max:255',
            'image_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ];

        // Only require rating for admin
        if ($user->isAdmin()) {
            $validationRules['rating'] = 'required|numeric|min:0|max:5';
        }

        $request->validate($validationRules);

        $data = $request->all();
        
        // Handle image upload
        if ($request->hasFile('image_upload')) {
            $image = $request->file('image_upload');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('sellers', $imageName, 'public');
            $data['image'] = $imagePath;
        } else {
            // Use selected image from existing options
            $data['image'] = $request->image;
        }
        
        // If seller, don't allow changing seller info
        if ($user->isSeller()) {
            unset($data['seller_name']);
            unset($data['seller_photo']);
        }

        $product->update($data);

        return redirect()->route('admin.products')
            ->with('success', 'Product updated successfully!');
    }

    public function deleteProduct(Product $product)
    {
        // Check if user is admin or seller
        if (!auth()->user()->isAdminOrSeller()) {
            abort(403, 'Unauthorized access');
        }

        $user = auth()->user();
        
        // If seller, check if product belongs to them
        if ($user->isSeller() && $product->seller_name !== $user->name) {
            abort(403, 'Unauthorized access. You can only delete your own products.');
        }

        $product->delete();

        return redirect()->route('admin.products')
            ->with('success', 'Product deleted successfully!');
    }

    public function orders()
    {
        // Check if user is admin or seller
        if (!auth()->user()->isAdminOrSeller()) {
            abort(403, 'Unauthorized access');
        }

        $user = auth()->user();
        
        if ($user->isAdmin()) {
            // Admin sees all orders
            $orders = Order::with(['user', 'orderItems.product'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            // Seller sees only orders containing their products
            $orders = Order::whereHas('orderItems.product', function($query) use ($user) {
                $query->where('seller_name', $user->name);
            })->with(['user', 'orderItems.product'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('admin.orders.index', compact('orders', 'user'));
    }

    public function showOrder(Order $order)
    {
        // Check if user is admin or seller
        if (!auth()->user()->isAdminOrSeller()) {
            abort(403, 'Unauthorized access');
        }

        $user = auth()->user();
        
        // If seller, check if order contains their products
        if ($user->isSeller()) {
            $hasSellerProducts = $order->orderItems()->whereHas('product', function($query) use ($user) {
                $query->where('seller_name', $user->name);
            })->exists();
            
            if (!$hasSellerProducts) {
                abort(403, 'Unauthorized access. You can only view orders containing your products.');
            }
        }

        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.show', compact('order', 'user'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        // Check if user is admin or seller
        if (!auth()->user()->isAdminOrSeller()) {
            abort(403, 'Unauthorized access');
        }

        $user = auth()->user();
        
        // If seller, check if order contains their products
        if ($user->isSeller()) {
            $hasSellerProducts = $order->orderItems()->whereHas('product', function($query) use ($user) {
                $query->where('seller_name', $user->name);
            })->exists();
            
            if (!$hasSellerProducts) {
                abort(403, 'Unauthorized access. You can only update orders containing your products.');
            }
        }

        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // No notification to customer - seller already knows about the order

        return redirect()->back()
            ->with('success', 'Order status updated successfully!');
    }


    public function users()
    {
        // Check if user is admin only
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access. Admin privileges required.');
        }

        $users = User::where('role', 'user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function transactions()
    {
        // Check if user is admin only
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access. Admin privileges required.');
        }

        $transactions = Transaction::with(['user', 'order'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.transactions.index', compact('transactions'));
    }

    // Profile Management
    public function profile()
    {
        // Check if user is admin or seller
        if (!auth()->user()->isAdminOrSeller()) {
            abort(403, 'Unauthorized access');
        }

        $user = auth()->user();
        return view('admin.profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        // Check if user is admin or seller
        if (!auth()->user()->isAdminOrSeller()) {
            abort(403, 'Unauthorized access');
        }

        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string|max:1000',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'description' => $request->description,
        ];

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $photo = $request->file('profile_photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photoPath = $photo->storeAs('profiles', $photoName, 'public');
            $data['profile_photo'] = $photoPath;
        }

        $user->update($data);

        return redirect()->route('admin.profile')
            ->with('success', 'Profile updated successfully!');
    }

    public function changePassword(Request $request)
    {
        // Check if user is admin or seller
        if (!auth()->user()->isAdminOrSeller()) {
            abort(403, 'Unauthorized access');
        }

        $user = auth()->user();
        
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.profile')
            ->with('success', 'Password changed successfully!');
    }
}