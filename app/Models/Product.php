<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sku',
        'description',
        'price',
        'stock',
        'weight',
        'image',
        'qr_code',
        'pickup_location',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->sku)) {
                $product->sku = 'PROD-' . strtoupper(Str::random(8));
            }
        });

        // Generate QR Code setelah produk dibuat
        static::created(function ($product) {
            $product->generateQRCode();
        });
    }

    // Generate QR Code menggunakan SVG (tidak perlu imagick)
    public function generateQRCode()
    {
        try {
            $url = url("/product/{$this->slug}");
            
            // Generate QR Code sebagai SVG (tidak perlu imagick/GD)
            $qrCode = QrCode::format('svg')
                            ->size(300)
                            ->errorCorrection('H')
                            ->generate($url);
            
            $filename = "qrcodes/{$this->sku}.svg";
            Storage::disk('public')->put($filename, $qrCode);
            
            $this->update(['qr_code' => $filename]);
        } catch (\Exception $e) {
            \Log::error('QR Code generation failed: ' . $e->getMessage());
        }
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                     ->orWhere('sku', 'like', "%{$search}%");
    }

    // Helper untuk cek stok
    public function isInStock()
    {
        return $this->stock > 0;
    }

    // Kurangi stok
    public function decreaseStock($quantity)
    {
        $this->decrement('stock', $quantity);
    }
}