@php
    $currencies = [
        'JPY' => ['symbol' => '¥', 'position' => 'before', 'decimals' => 0],
        'VND' => ['symbol' => '₫', 'position' => 'after', 'decimals' => 0],
        'USD' => ['symbol' => '$', 'position' => 'before', 'decimals' => 2],
        'EUR' => ['symbol' => '€', 'position' => 'before', 'decimals' => 2],
        'CNY' => ['symbol' => '¥', 'position' => 'before', 'decimals' => 2],
        'KRW' => ['symbol' => '₩', 'position' => 'before', 'decimals' => 0],
    ];

    $currencyInfo = $currencies[$currency] ?? $currencies['JPY'];
    $formattedAmount = number_format($amount, $currencyInfo['decimals'], '.', ',');

    if ($currencyInfo['position'] === 'after') {
        $display = $formattedAmount . ' ' . $currencyInfo['symbol'];
    } else {
        $display = $currencyInfo['symbol'] . $formattedAmount;
    }
@endphp

<span {{ $attributes->merge(['class' => 'currency']) }}>{{ $display }}</span>

{{--
Sử dụng:
<x-currency :amount="$product->price" :currency="$product->currency" class="text-primary font-weight-bold" />
--}}
