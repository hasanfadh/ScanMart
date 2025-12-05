<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'session_id',
        'product_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Relationship
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Hitung subtotal per item
    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }

    // Scope untuk session tertentu
    public function scopeForSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    // Static method untuk get total cart
    public static function getTotalForSession($sessionId)
    {
        return self::forSession($sessionId)
                   ->get()
                   ->sum(function ($item) {
                       return $item->subtotal;
                   });
    }

    // Static method untuk get item count
    public static function getItemCountForSession($sessionId)
    {
        return self::forSession($sessionId)->sum('quantity');
    }
}