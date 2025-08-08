<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'province',
        'city',
        'zone_name',
        'base_fee',
        'delivery_days',
    ];

    protected $casts = [
        'base_fee' => 'decimal:2',
    ];

    // Scopes
    public function scopeByProvince($query, $province)
    {
        return $query->where('province', $province);
    }

    public function scopeByCity($query, $city)
    {
        return $query->where('city', $city);
    }

    public function scopeByLocation($query, $province, $city = null)
    {
        return $query->where('province', $province)
                    ->where(function($q) use ($city) {
                        $q->where('city', $city)->orWhereNull('city');
                    });
    }
    // Relationship với Orders
    // public function orders(): HasMany
    // {
    //     return $this->hasMany(Order::class);
    // }
    // Methods
    public static function calculateShippingFee($province, $city = null)
    {
        $shippingRate = static::byLocation($province, $city)
                             ->orderByRaw('city IS NULL ASC') // city cụ thể trước, NULL sau
                             ->first();

        if (!$shippingRate) {
            return [
                'success' => false,
                'message' => 'Không hỗ trợ giao hàng đến khu vực này'
            ];
        }

        return [
            'success' => true,
            'fee' => $shippingRate->base_fee,
            'zone_name' => $shippingRate->zone_name,
            'delivery_days' => $shippingRate->delivery_days,
            'shipping_rate' => $shippingRate
        ];
    }

    public static function getAvailableProvinces()
    {
        return static::select('province')
                    ->distinct()
                    ->orderBy('province')
                    ->pluck('province');
    }

    public static function getCitiesByProvince($province)
    {
        return static::where('province', $province)
                    ->whereNotNull('city')
                    ->select('city')
                    ->distinct()
                    ->orderBy('city')
                    ->pluck('city');
    }

    // Accessors
    public function getFormattedBaseFeeAttribute()
    {
        return '¥ ' . number_format($this->base_fee);
    }

    public function getFullLocationAttribute()
    {
        if ($this->city) {
            return $this->city . ', ' . $this->province;
        }
        return $this->province;
    }
}
