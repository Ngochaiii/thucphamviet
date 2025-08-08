<?php

namespace App\Models;

use App\Helpers\CurrencyHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'unit_id',
        'name',
        'jp_name',
        'slug',
        'description',
        'specification',
        'price',
        'quantity',
        'status',
        'discount',
        'image',
        'images',
        'rating_avg',
        'rating_count',
        'is_featured',
        'currency',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'rating_avg' => 'decimal:2',
        'rating_count' => 'integer',
        'quantity' => 'integer',
        'is_featured' => 'boolean',
        'images' => 'array',
    ];

    protected $attributes = [
        'status' => 'active',
        'discount' => 0,
        'rating_avg' => 0,
        'rating_count' => 0,
        'is_featured' => false,
        'quantity' => 0,
        'currency' => 'JPY',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(ProductReview::class)->where('is_approved', true);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(ShoppingCart::class);
    }

    public function wishlistItems()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'wishlists');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%")
              ->orWhere('jp_name', 'like', "%{$keyword}%");
        });
    }

    // Accessors
    public function getDiscountedPriceAttribute()
    {
        if ($this->discount > 0) {
            return $this->price * (1 - $this->discount / 100);
        }
        return $this->price;
    }

    public function getIsInStockAttribute()
    {
        return $this->quantity > 0;
    }

    public function getIsDiscountedAttribute()
    {
        return $this->discount > 0;
    }

    // Methods
    public function updateRating()
    {
        $reviews = $this->approvedReviews();
        $this->rating_count = $reviews->count();
        $this->rating_avg = $reviews->avg('rating') ?: 0;
        $this->save();
    }
    // Accessor để format giá
public function getFormattedPriceAttribute()
{
    return CurrencyHelper::formatPrice($this->price, $this->currency);
}

// Accessor để format giá sau giảm
public function getFormattedDiscountedPriceAttribute()
{
    return CurrencyHelper::formatPrice($this->discounted_price, $this->currency);
}
}
