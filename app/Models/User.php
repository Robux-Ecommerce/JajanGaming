<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'wallet_balance',
        'role',
        'profile_photo',
        'description',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'wallet_balance' => 'decimal:2',
            'role' => 'string',
        ];
    }

    // Relationships
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    // Role methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isSeller()
    {
        return $this->role === 'seller';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function isAdminOrSeller()
    {
        return in_array($this->role, ['admin', 'seller']);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function unreadNotifications()
    {
        return $this->hasMany(Notification::class)->unread();
    }

    public function products()
    {
        // Use seller_id if column exists, otherwise relationship won't work
        // For fallback, use getSellerProducts() method instead
        if (\Illuminate\Support\Facades\Schema::hasColumn('products', 'seller_id')) {
            return $this->hasMany(Product::class, 'seller_id');
        } else {
            // Return empty relationship if seller_id doesn't exist
            // Use getSellerProducts() method for querying
            return $this->hasMany(Product::class, 'seller_id')->whereRaw('1 = 0');
        }
    }
    
    // Helper method to get seller products (works with or without seller_id column)
    public function getSellerProducts()
    {
        if (\Illuminate\Support\Facades\Schema::hasColumn('products', 'seller_id')) {
            return Product::where('seller_id', $this->id);
        } else {
            return Product::where('seller_name', $this->name);
        }
    }

    // Report relationships
    public function reportsSubmitted()
    {
        return $this->hasMany(Report::class, 'user_id');
    }

    public function reportsAgainst()
    {
        return $this->hasMany(Report::class, 'seller_id');
    }
}
