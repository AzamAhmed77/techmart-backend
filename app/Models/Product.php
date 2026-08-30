<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'old_price',
        'rating',
        'reviews_count',
        'category',
        'image_url',
        'is_featured',
        'stock',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'float',
            'old_price' => 'float',
            'rating' => 'float',
            'reviews_count' => 'integer',
            'is_featured' => 'boolean',
            'stock' => 'integer',
        ];
    }
}
