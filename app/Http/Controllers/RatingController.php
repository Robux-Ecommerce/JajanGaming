<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        // Debug: Log all request data
        \Log::info('Rating submission request:', $request->all());
        
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::findOrFail($request->order_id);
        
        // Check if user owns this order
        if ($order->user_id !== Auth::id()) {
            \Log::warning('Unauthorized rating attempt', ['user_id' => Auth::id(), 'order_user_id' => $order->user_id]);
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Check if order is completed
        if ($order->status !== 'completed') {
            \Log::warning('Rating attempt on non-completed order', ['order_id' => $order->id, 'status' => $order->status]);
            return response()->json(['success' => false, 'message' => 'Order must be completed to rate'], 400);
        }

        $ratings = [];
        
        // Process ratings for each product
        foreach ($order->orderItems as $item) {
            $ratingKey = "rating_{$item->product_id}";
            $reviewKey = "review_{$item->product_id}";
            
            \Log::info("Processing product {$item->product_id}, looking for key: {$ratingKey}");
            
            if ($request->has($ratingKey)) {
                $ratingValue = $request->input($ratingKey);
                \Log::info("Found rating for product {$item->product_id}: {$ratingValue}");
                
                // Validate rating (1-5)
                if ($ratingValue >= 1 && $ratingValue <= 5) {
                    // Check if rating already exists
                    $existingRating = Rating::where('user_id', Auth::id())
                        ->where('product_id', $item->product_id)
                        ->where('order_id', $order->id)
                        ->first();
                    
                    if ($existingRating) {
                        // Update existing rating
                        $existingRating->update([
                            'rating' => $ratingValue,
                            'review' => $request->input($reviewKey, ''),
                        ]);
                    } else {
                        // Create new rating
                        Rating::create([
                            'user_id' => Auth::id(),
                            'product_id' => $item->product_id,
                            'order_id' => $order->id,
                            'rating' => $ratingValue,
                            'review' => $request->input($reviewKey, ''),
                        ]);
                    }
                    
                    $ratings[] = [
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'rating' => $ratingValue,
                        'review' => $request->input($reviewKey, ''),
                    ];
                }
            }
        }

        \Log::info('Rating submission successful', ['ratings' => $ratings]);
        
        return response()->json([
            'success' => true,
            'message' => 'Rating submitted successfully',
            'ratings' => $ratings
        ]);
    }

    public function index()
    {
        $ratings = Rating::where('user_id', Auth::id())
            ->with(['product', 'order'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('ratings.index', compact('ratings'));
    }

    // Store a rating submitted from product page
    public function storeForProduct(Request $request, \App\Models\Product $product)
    {
        $request->validate([
            'rating' => 'nullable|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        // Ensure only authenticated users can submit
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'You must be logged in to submit a review.');
        }

        $user = Auth::user();

        // Optional: require user to have bought product
        $hasPurchased = \App\Models\Order::where('user_id', $user->id)
            ->where('status', 'completed')
            ->whereHas('orderItems', function($q) use ($product) {
                $q->where('product_id', $product->id);
            })->exists();

        if (! $hasPurchased) {
            return redirect()->back()->with('error', 'You can only leave reviews after purchasing this product.');
        }

        $ratingValue = $request->input('rating', null);
        $reviewText = $request->input('review', null);

        // Update existing rating for this user/product or create
        $rating = Rating::firstOrNew([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        if ($ratingValue) {
            $rating->rating = $ratingValue;
        }
        $rating->review = $reviewText ?? $rating->review;
        $rating->save();

        return redirect()->back()->with('success', 'Thank you — your review has been submitted.');
    }
}