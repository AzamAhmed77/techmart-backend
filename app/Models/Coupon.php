<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_percentage',
        'max_discount_amount',
        'min_order_amount',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'discount_percentage' => 'integer',
        'max_discount_amount' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function isValidForAmount(float $amount): bool
    {
        if (!$this->is_active) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($amount < (float) $this->min_order_amount) return false;
        return true;
    }

    public function calculateDiscount(float $amount): float
    {
        $discount = ($amount * $this->discount_percentage) / 100.0;
        if ($this->max_discount_amount && $discount > (float) $this->max_discount_amount) {
            $discount = (float) $this->max_discount_amount;
        }
        return round($discount, 2);
    }
}
