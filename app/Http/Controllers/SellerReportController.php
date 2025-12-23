<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class SellerReportController extends Controller
{
    // Display all reports about this seller
    public function index()
    {
        $sellerId = auth()->user()->id;

        // Get all reports for this seller
        $reports = Report::where('seller_id', $sellerId)
            ->with(['reporter', 'product'])
            ->orderByDesc('created_at')
            ->paginate(15);

        // Get stats
        $totalReports = Report::where('seller_id', $sellerId)->count();
        $pendingReports = Report::where('seller_id', $sellerId)->where('status', 'pending')->count();
        $respondedReports = Report::where('seller_id', $sellerId)->where('status', 'responded')->count();
        $resolvedReports = Report::where('seller_id', $sellerId)->where('status', 'resolved')->count();

        return view('seller.reports.index', [
            'reports' => $reports,
            'totalReports' => $totalReports,
            'pendingReports' => $pendingReports,
            'respondedReports' => $respondedReports,
            'resolvedReports' => $resolvedReports,
        ]);
    }

    // View single report detail
    public function show($reportId)
    {
        $report = Report::with(['reporter', 'product'])
            ->findOrFail($reportId);

        // Make sure this report is about the current seller
        if ($report->seller_id !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }

        return view('seller.reports.show', ['report' => $report]);
    }

    // Submit response to a report
    public function respond(Request $request, $reportId)
    {
        $report = Report::findOrFail($reportId);

        // Make sure this report is about the current seller
        if ($report->seller_id !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }

        // Validate response
        $validated = $request->validate([
            'response' => 'required|string|min:10|max:1000',
        ]);

        $report->update([
            'seller_response' => $validated['response'],
            'status' => 'responded',
        ]);

        return back()->with('success', 'Response submitted successfully. Admin will review your response.');
    }
}
