{{-- resources/views/components/currency.blade.php --}}
@php
    use App\Helpers\CurrencyHelper;

    // Sử dụng CurrencyHelper thay vì tự định nghĩa
    $formattedPrice = CurrencyHelper::formatPrice($amount, $currency);
@endphp

<span {{ $attributes->merge(['class' => 'currency']) }}>{{ $formattedPrice }}</span>

{{--
Cách sử dụng:
1. Hiển thị giá gốc:
<x-currency :amount="$product->price" :currency="$product->currency" class="text-primary fw-bold" />

2. Hiển thị giá sau giảm:
<x-currency :amount="$product->discounted_price" :currency="$product->currency" class="text-danger fw-bold" />

3. Sử dụng accessor từ model:
{{ $product->formatted_price }} - sử dụng getFormattedPriceAttribute()
{{ $product->formatted_discounted_price }} - sử dụng getFormattedDiscountedPriceAttribute()
--}}
