<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WishlistController extends Controller
{
    /**
     * Toggle product in wishlist.
     */
    public function toggle(Request $request): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login first'
            ], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'action' => 'required|in:add,remove'
        ]);

        $user = auth()->user();
        $productId = $request->product_id;
        $action = $request->action;

        try {
            if ($action === 'add') {
                // Check if already in wishlist
                $exists = Wishlist::where('user_id', $user->id)
                    ->where('product_id', $productId)
                    ->first();

                if (!$exists) {
                    Wishlist::create([
                        'user_id' => $user->id,
                        'product_id' => $productId,
                    ]);
                }
            } else {
                // Remove from wishlist
                Wishlist::where('user_id', $user->id)
                    ->where('product_id', $productId)
                    ->delete();
            }

            return response()->json([
                'success' => true,
                'message' => $action === 'add' ? 'Added to wishlist' : 'Removed from wishlist'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating wishlist'
            ], 500);
        }
    }

    /**
     * Check if product is in user's wishlist.
     */
    public function check(Request $request): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['inWishlist' => false]);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $inWishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->exists();

        return response()->json(['inWishlist' => $inWishlist]);
    }

    /**
     * Get user's wishlist.
     */
    public function index(): \Illuminate\View\View
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $wishlist = Wishlist::where('user_id', auth()->id())
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('wishlist.index', compact('wishlist'));
    }

    /**
     * Remove item from wishlist.
     */
    public function destroy($id): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login first'
            ], 401);
        }

        $wishlist = Wishlist::find($id);

        if (!$wishlist || $wishlist->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Not found'
            ], 404);
        }

        $wishlist->delete();

        return response()->json([
            'success' => true,
            'message' => 'Removed from wishlist'
        ]);
    }
}
