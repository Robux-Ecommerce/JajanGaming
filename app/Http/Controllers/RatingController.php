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
}