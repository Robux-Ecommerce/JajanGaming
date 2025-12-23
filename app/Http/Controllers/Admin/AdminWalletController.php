<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminWallet;
use App\Models\AdminTaxHistory;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminWalletController extends Controller
{
    public function index()
    {
        $adminWallet = AdminWallet::first() ?? AdminWallet::create([
            'total_balance' => 0,
            'total_tax_collected' => 0,
        ]);

        // Get stats
        $todayTax = AdminWallet::getTodayTax();
        $thisMonthTax = AdminWallet::getThisMonthTax();
        $totalTax = $adminWallet->total_balance;

        // Get monthly data for chart (last 12 months)
        $monthlyData = $this->getMonthlyTaxData();

        // Get daily data for this month
        $dailyData = $this->getDailyTaxData();

        // Get recent transactions
        $recentTaxes = AdminTaxHistory::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.wallet.index', [
            'adminWallet' => $adminWallet,
            'todayTax' => $todayTax,
            'thisMonthTax' => $thisMonthTax,
            'totalTax' => $totalTax,
            'monthlyData' => $monthlyData,
            'dailyData' => $dailyData,
            'recentTaxes' => $recentTaxes,
        ]);
    }

    public function getMonthlyTaxData()
    {
        $months = [];
        $data = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            $tax = AdminTaxHistory::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('amount');
            $data[] = (float)$tax;
        }

        return [
            'labels' => $months,
            'data' => $data,
        ];
    }

    public function getDailyTaxData()
    {
        $days = [];
        $data = [];

        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        for ($i = 0; $i < $endOfMonth->day; $i++) {
            $date = $startOfMonth->copy()->addDays($i);
            $days[] = $date->format('d M');
            $tax = AdminTaxHistory::whereDate('created_at', $date)
                ->sum('amount');
            $data[] = (float)$tax;
        }

        return [
            'labels' => $days,
            'data' => $data,
        ];
    }

    public function history(Request $request)
    {
        $query = AdminTaxHistory::query();

        // Filter by date range
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter by month
        if ($request->has('month') && $request->month) {
            [$year, $month] = explode('-', $request->month);
            $query->whereYear('created_at', $year)
                ->whereMonth('created_at', $month);
        }

        $taxes = $query->orderBy('created_at', 'desc')
            ->paginate(20);

        $totalInRange = $query->sum('amount');

        return view('admin.wallet.history', [
            'taxes' => $taxes,
            'totalInRange' => $totalInRange,
        ]);
    }

    public function export(Request $request)
    {
        $query = AdminTaxHistory::query();

        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $taxes = $query->orderBy('created_at', 'desc')->get();

        // Generate CSV
        $filename = 'admin-wallet-export-' . now()->format('Y-m-d-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($taxes) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Tanggal', 'Jumlah Pajak', 'Tarif Pajak', 'Deskripsi']);

            foreach ($taxes as $tax) {
                fputcsv($file, [
                    $tax->created_at->format('d-m-Y H:i:s'),
                    number_format($tax->amount, 2, ',', '.'),
                    $tax->tax_rate . '%',
                    $tax->description,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function addTaxFromTransaction($transactionId, $amount, $rate = 10)
    {
        $transaction = Transaction::find($transactionId);
        if (!$transaction) {
            return false;
        }

        $taxAmount = ($amount * $rate) / 100;

        // Record tax history
        AdminTaxHistory::create([
            'transaction_id' => $transactionId,
            'order_id' => $transaction->order_id,
            'amount' => $taxAmount,
            'tax_rate' => $rate,
            'description' => "Pajak dari transaksi #{$transactionId}",
        ]);

        // Update admin wallet
        $adminWallet = AdminWallet::first();
        if ($adminWallet) {
            $adminWallet->update([
                'total_balance' => $adminWallet->total_balance + $taxAmount,
                'total_tax_collected' => $adminWallet->total_tax_collected + $taxAmount,
                'last_updated' => now(),
            ]);
        }

        return true;
    }
}
