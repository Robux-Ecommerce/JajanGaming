<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image',
        'button_text',
        'button_url',
        'start_date',
        'end_date',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function scopeActive($query)
    {
        $now = now()->toDateString();
        return $query->where('is_active', true)
            ->where(function($q) use ($now) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', $now);
            })
            ->where(function($q) use ($now) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', $now);
            });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
