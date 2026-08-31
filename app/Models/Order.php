<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'status',
        'subtotal',
        'discount',
        'shipping_fee',
        'total',
        'payment_method',
        'payment_status',
        'recipient_name',
        'phone',
        'shipping_address',
        'city',
        'coupon_code',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber(): string
    {
        return 'TM-' . strtoupper(substr(uniqid(), -6)) . '-' . rand(100, 999);
    }

    public function getStatusArabicAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'قيد الانتظار',
            'processing' => 'قيد التجهيز',
            'shipped' => 'تم الشحن',
            'delivered' => 'تم التسليم',
            'cancelled' => 'ملغي',
            default => $this->status,
        };
    }
}
