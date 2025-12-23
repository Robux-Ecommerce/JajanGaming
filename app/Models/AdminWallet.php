<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminWallet extends Model
{
    protected $table = 'admin_wallets';
    
    protected $fillable = [
        'total_balance',
        'total_tax_collected',
        'last_updated',
    ];

    protected $casts = [
        'total_balance' => 'decimal:2',
        'total_tax_collected' => 'decimal:2',
        'last_updated' => 'datetime',
    ];

    // Get tax history by date
    public static function getTaxByDate($date)
    {
        return AdminTaxHistory::whereDate('created_at', $date)->sum('amount');
    }

    // Get tax history by month
    public static function getTaxByMonth($year, $month)
    {
        return AdminTaxHistory::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->sum('amount');
    }

    // Get today's tax
    public static function getTodayTax()
    {
        return AdminTaxHistory::whereDate('created_at', now())
            ->sum('amount');
    }

    // Get this month tax
    public static function getThisMonthTax()
    {
        return AdminTaxHistory::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('amount');
    }
}
