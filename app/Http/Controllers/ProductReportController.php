<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Product;
use App\Models\Notification;
use Illuminate\Http\Request;

class ProductReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Store report for a product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'reason' => 'required|in:poor_quality,fake_product,unsafe,inappropriate,other',
            'description' => 'required|string|min:10|max:500',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        // Check if user already reported this product
        $existingReport = Report::where([
            'user_id' => auth()->user()->id,
            'product_id' => $validated['product_id'],
        ])->where('status', '!=', 'resolved')->first();

        if ($existingReport) {
            return back()->with('error', 'Anda sudah melaporkan produk ini sebelumnya.');
        }

        // Create report
        $report = Report::create([
            'user_id' => auth()->user()->id,
            'seller_id' => $product->seller_id,
            'product_id' => $validated['product_id'],
            'reason' => $validated['reason'],
            'description' => $validated['description'],
            'status' => 'pending',
        ]);

        // Notify seller about the report
        Notification::create([
            'user_id' => $product->seller_id,
            'title' => 'Laporan Produk Baru',
            'message' => 'Produk "' . $product->name . '" anda telah dilaporkan oleh pembeli. Silakan cek akun anda.',
            'type' => 'report_received',
            'related_id' => $report->id,
        ]);

        return back()->with('success', 'Laporan anda telah dikirim ke admin. Terima kasih telah membantu menjaga kualitas platform.');
    }

    // Check if user already reported a product
    public function check($productId)
    {
        $hasReported = Report::where([
            'user_id' => auth()->user()->id,
            'product_id' => $productId,
        ])->where('status', '!=', 'resolved')->exists();

        return response()->json(['has_reported' => $hasReported]);
    }
}
