<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrowseController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SellerProfileController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ProductReportController;
use App\Http\Controllers\SellerReportController;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Rating;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/browse', [BrowseController::class, 'index'])->name('browse');
Route::get('/product/{product}', [HomeController::class, 'showProduct'])->name('product.show');
Route::get('/products/{product}', [HomeController::class, 'showProduct'])->name('products.show');

// Product Report route (public for authenticated users)
Route::post('/product/{product}/report', [ProductReportController::class, 'store'])->middleware('auth')->name('product.report');
Route::get('/product/{product}/report-check', [ProductReportController::class, 'check'])->middleware('auth')->name('product.report.check');

// Seller Profile routes (public) - moved to avoid conflict with seller dashboard
Route::get('/sellers', [SellerProfileController::class, 'index'])->name('sellers.index');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected routes
Route::middleware('auth')->group(function () {
    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    // Order routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');

    // Wallet routes
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::post('/wallet/topup', [WalletController::class, 'topup'])->name('wallet.topup');

    // Payment routes
    Route::get('/payment/process/{order}', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('/payment/topup/{transaction}', [PaymentController::class, 'topup'])->name('payment.topup');
    Route::post('/payment/success', [PaymentController::class, 'simulateSuccess'])->name('payment.success');
    Route::post('/payment/failed', [PaymentController::class, 'simulateFailed'])->name('payment.failed');
    Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');

    // User Profile routes
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [UserProfileController::class, 'updatePassword'])->name('profile.password');

    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::get('/api/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::get('/api/notifications/recent', [NotificationController::class, 'getRecentNotifications'])->name('notifications.recent');

    // Rating routes
    Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');
    Route::get('/ratings', [RatingController::class, 'index'])->name('ratings.index');
    
    // Wishlist routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/wishlist/check', [WishlistController::class, 'check'])->name('wishlist.check');
    Route::delete('/wishlist/{wishlist}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    
    // Debug route for testing rating
    Route::get('/debug-rating/{order}', function($orderId) {
        $order = \App\Models\Order::findOrFail($orderId);
        return response()->json([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'status' => $order->status,
            'order_items' => $order->orderItems->map(function($item) {
                return [
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                ];
            })
        ]);
    })->name('debug.rating');

    // Cart API routes
    Route::get('/api/cart/count', [CartController::class, 'getCount'])->name('cart.count');
});

// Admin/Seller routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Products management
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}', [AdminController::class, 'deleteProduct'])->name('products.destroy');
    
    // Orders management
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::put('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.update-status');
    
    // Profile management
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [AdminController::class, 'changePassword'])->name('profile.password');
    
    // Users management (Admin only)
    Route::middleware('admin')->group(function () {
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions');
        Route::get('/transactions/export', [AdminController::class, 'exportTransactions'])->name('transactions.export');
        
        // Admin Wallet routes
        Route::get('/wallet', [\App\Http\Controllers\Admin\AdminWalletController::class, 'index'])->name('wallet.index');
        Route::get('/wallet/history', [\App\Http\Controllers\Admin\AdminWalletController::class, 'history'])->name('wallet.history');
        Route::get('/wallet/export', [\App\Http\Controllers\Admin\AdminWalletController::class, 'export'])->name('wallet.export');

        // Report management routes
        Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/seller/{seller}', [\App\Http\Controllers\Admin\ReportController::class, 'detail'])->name('reports.detail');
        Route::get('/reports/{report}', [\App\Http\Controllers\Admin\ReportController::class, 'view'])->name('reports.view');
        Route::post('/reports/{report}/dismiss', [\App\Http\Controllers\Admin\ReportController::class, 'dismiss'])->name('reports.dismiss');
        Route::post('/reports/seller/{seller}/blacklist', [\App\Http\Controllers\Admin\ReportController::class, 'blacklist'])->name('reports.blacklist');
        Route::post('/reports/seller/{seller}/remove-blacklist', [\App\Http\Controllers\Admin\ReportController::class, 'removeBlacklist'])->name('reports.remove-blacklist');
        Route::get('/reports/export', [\App\Http\Controllers\Admin\ReportController::class, 'export'])->name('reports.export');
    });
});

// Seller Report routes (inside auth middleware)
Route::middleware('auth')->group(function () {
    Route::get('/seller/reports', [SellerReportController::class, 'index'])->name('seller.reports.index');
    Route::get('/seller/reports/{report}', [SellerReportController::class, 'show'])->name('seller.reports.show');
    Route::post('/seller/reports/{report}/respond', [SellerReportController::class, 'respond'])->name('seller.reports.respond');
});

// Seller routes (separate from admin) - must be before /seller/{sellerId} route
Route::middleware('auth')->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\SellerController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [\App\Http\Controllers\SellerController::class, 'orders'])->name('orders.index');
    Route::get('/transactions', [\App\Http\Controllers\SellerController::class, 'transactions'])->name('transactions');
    Route::get('/wallet', [\App\Http\Controllers\SellerController::class, 'wallet'])->name('wallet');
    Route::get('/profile', [\App\Http\Controllers\SellerController::class, 'profile'])->name('profile');
    Route::put('/profile', [\App\Http\Controllers\SellerController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\SellerController::class, 'changePassword'])->name('profile.password');
    
    Route::resource('products', \App\Http\Controllers\SellerProductController::class);
});

// Seller Profile public route (must be after seller routes to avoid conflict)
Route::get('/seller/{sellerId}', [SellerProfileController::class, 'show'])->name('seller.profile');

// API routes for auth pages
Route::get('/api/stats', function () {
    return response()->json([
        'users' => User::count(),
        'transactions' => Transaction::count(),
        'avgRating' => Rating::avg('rating') ?? 0,
    ]);
})->name('api.stats');

