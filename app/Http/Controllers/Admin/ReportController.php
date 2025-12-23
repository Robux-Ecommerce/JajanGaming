<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // Display all reports grouped by seller
    public function index()
    {
        // Get sellers with their report counts, ordered by most reports
        $sellers = User::where('role', 'seller')
            ->withCount('reportsAgainst')
            ->having('reports_against_count', '>', 0)
            ->orderByDesc('reports_against_count')
            ->paginate(15);

        // Get overall stats
        $totalReports = Report::count();
        $pendingReports = Report::where('status', 'pending')->count();
        $respondedReports = Report::where('status', 'responded')->count();
        $resolvedReports = Report::where('status', 'resolved')->count();
        $blacklistedSellers = User::where('is_blacklisted', true)->count();

        return view('admin.reports.index', [
            'sellers' => $sellers,
            'totalReports' => $totalReports,
            'pendingReports' => $pendingReports,
            'respondedReports' => $respondedReports,
            'resolvedReports' => $resolvedReports,
            'blacklistedSellers' => $blacklistedSellers,
        ]);
    }

    // Display reports for a specific seller
    public function detail($sellerId)
    {
        $seller = User::findOrFail($sellerId);

        // Get all reports for this seller, grouped by status
        $reports = Report::where('seller_id', $sellerId)
            ->with(['reporter', 'product'])
            ->orderByDesc('created_at')
            ->paginate(20);

        // Get stats for this seller
        $reportCount = Report::where('seller_id', $sellerId)->count();
        $pendingCount = Report::where('seller_id', $sellerId)->where('status', 'pending')->count();
        $respondedCount = Report::where('seller_id', $sellerId)->where('status', 'responded')->count();

        return view('admin.reports.detail', [
            'seller' => $seller,
            'reports' => $reports,
            'reportCount' => $reportCount,
            'pendingCount' => $pendingCount,
            'respondedCount' => $respondedCount,
        ]);
    }

    // View single report
    public function view($reportId)
    {
        $report = Report::with(['reporter', 'seller', 'product'])
            ->findOrFail($reportId);

        return view('admin.reports.view', ['report' => $report]);
    }

    // Dismiss a report
    public function dismiss($reportId)
    {
        $report = Report::findOrFail($reportId);

        $report->update([
            'status' => 'resolved',
            'action_taken' => 'dismissed',
            'admin_notes' => request('admin_notes') ?? 'Report dismissed by admin',
        ]);

        // Notify seller that report was dismissed
        Notification::create([
            'user_id' => $report->seller_id,
            'title' => 'Laporan Ditolak',
            'message' => 'Laporan tentang produk anda dari ' . $report->reporter->name . ' telah ditinjau dan ditolak oleh admin.',
            'type' => 'report_dismissed',
            'related_id' => $report->id,
        ]);

        return back()->with('success', 'Report dismissed successfully');
    }

    // Blacklist seller
    public function blacklist($sellerId)
    {
        $seller = User::findOrFail($sellerId);

        $seller->update([
            'is_blacklisted' => true,
            'suspended_reason' => request('reason') ?? 'Multiple reports dari pembeli',
            'suspended_at' => now(),
        ]);

        // Update all pending/responded reports for this seller to resolved
        Report::where('seller_id', $sellerId)
            ->whereIn('status', ['pending', 'responded'])
            ->update([
                'status' => 'resolved',
                'action_taken' => 'blacklisted',
            ]);

        // Notify seller they've been blacklisted
        Notification::create([
            'user_id' => $sellerId,
            'title' => 'Akun Dinonaktifkan',
            'message' => 'Akun seller anda telah dinonaktifkan karena banyaknya laporan dari pembeli. Alasan: ' . ($seller->suspended_reason ?? 'Multiple violations'),
            'type' => 'account_suspended',
            'related_id' => $sellerId,
        ]);

        return back()->with('success', 'Seller has been blacklisted successfully');
    }

    // Remove blacklist
    public function removeBlacklist($sellerId)
    {
        $seller = User::findOrFail($sellerId);

        $seller->update([
            'is_blacklisted' => false,
            'suspended_reason' => null,
            'suspended_at' => null,
        ]);

        // Notify seller
        Notification::create([
            'user_id' => $sellerId,
            'title' => 'Akun Diaktifkan Kembali',
            'message' => 'Akun seller anda telah diaktifkan kembali oleh admin. Anda dapat berjualan kembali.',
            'type' => 'account_activated',
            'related_id' => $sellerId,
        ]);

        return back()->with('success', 'Seller has been removed from blacklist');
    }

    // Export reports to CSV
    public function export(Request $request)
    {
        $query = Report::with(['reporter', 'seller', 'product']);

        if ($request->has('seller_id') && $request->seller_id) {
            $query->where('seller_id', $request->seller_id);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $reports = $query->get();

        $csvData = "Report ID,Reporter,Seller,Product,Reason,Status,Action Taken,Date\n";

        foreach ($reports as $report) {
            $csvData .= "{$report->id}," .
                       "\"{$report->reporter->name}\"," .
                       "\"{$report->seller->name}\"," .
                       "\"{$report->product->name}\"," .
                       "{$report->reason}," .
                       "{$report->status}," .
                       "{$report->action_taken}," .
                       "{$report->created_at->format('Y-m-d H:i:s')}\n";
        }

        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="reports_' . date('Y-m-d_H-i-s') . '.csv"');
    }
}
