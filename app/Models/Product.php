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
        'discount',
        'image',
        'category',
        'stock',
    ];

    // Final price after discount applied
    public function getDiscountedPriceAttribute()
    {
        if ($this->discount > 0) {
            return round($this->price - ($this->price * $this->discount / 100));
        }
        return $this->price;
    }

    // Amount saved
    public function getSavingAmountAttribute()
    {
        return $this->price - $this->discounted_price;
    }

    // Has active discount
    public function getHasDiscountAttribute()
    {
        return $this->discount > 0;
    }
    public function categories()
    {
        return $this->belongsToMany(\App\Models\Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}