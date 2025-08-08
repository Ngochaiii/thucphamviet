<?php

namespace App\Helpers;

class CurrencyHelper
{
    /**
     * Danh sách các loại tiền tệ hỗ trợ
     */
    public static function getSupportedCurrencies()
    {
        return [
            'JPY' => [
                'name' => 'Yên Nhật',
                'symbol' => '¥',
                'symbol_position' => 'before', // before hoặc after
                'decimal_places' => 0, // Yên không có số thập phân
                'thousand_separator' => ',',
                'decimal_separator' => '.',
            ],
            'VND' => [
                'name' => 'Đồng Việt Nam',
                'symbol' => '₫',
                'symbol_position' => 'after',
                'decimal_places' => 0,
                'thousand_separator' => '.',
                'decimal_separator' => ',',
            ],
            'USD' => [
                'name' => 'Đô la Mỹ',
                'symbol' => '$',
                'symbol_position' => 'before',
                'decimal_places' => 2,
                'thousand_separator' => ',',
                'decimal_separator' => '.',
            ],
            'EUR' => [
                'name' => 'Euro',
                'symbol' => '€',
                'symbol_position' => 'before',
                'decimal_places' => 2,
                'thousand_separator' => ',',
                'decimal_separator' => '.',
            ],
            'CNY' => [
                'name' => 'Nhân dân tệ',
                'symbol' => '¥',
                'symbol_position' => 'before',
                'decimal_places' => 2,
                'thousand_separator' => ',',
                'decimal_separator' => '.',
            ],
            'KRW' => [
                'name' => 'Won Hàn Quốc',
                'symbol' => '₩',
                'symbol_position' => 'before',
                'decimal_places' => 0,
                'thousand_separator' => ',',
                'decimal_separator' => '.',
            ],
        ];
    }

    /**
     * Lấy danh sách currencies cho dropdown
     */
    public static function getCurrencyOptions()
    {
        $currencies = self::getSupportedCurrencies();
        $options = [];

        foreach ($currencies as $code => $info) {
            $options[$code] = "{$info['name']} ({$info['symbol']})";
        }

        return $options;
    }

    /**
     * Format giá theo currency
     */
    public static function formatPrice($price, $currency = 'JPY')
    {
        $currencies = self::getSupportedCurrencies();

        if (!isset($currencies[$currency])) {
            $currency = 'JPY'; // Fallback về JPY
        }

        $config = $currencies[$currency];

        // Format số
        $formattedPrice = number_format(
            $price,
            $config['decimal_places'],
            $config['decimal_separator'],
            $config['thousand_separator']
        );

        // Thêm ký hiệu tiền tệ
        if ($config['symbol_position'] === 'before') {
            return $config['symbol'] . $formattedPrice;
        } else {
            return $formattedPrice . ' ' . $config['symbol'];
        }
    }

    /**
     * Lấy thông tin currency
     */
    public static function getCurrencyInfo($currency)
    {
        $currencies = self::getSupportedCurrencies();
        return $currencies[$currency] ?? $currencies['JPY'];
    }

    /**
     * Lấy symbol của currency
     */
    public static function getCurrencySymbol($currency)
    {
        $info = self::getCurrencyInfo($currency);
        return $info['symbol'];
    }

    /**
     * Lấy tên currency
     */
    public static function getCurrencyName($currency)
    {
        $info = self::getCurrencyInfo($currency);
        return $info['name'];
    }

    /**
     * Chuyển đổi giá (cần API tỷ giá thực tế)
     * Đây chỉ là ví dụ với tỷ giá cố định
     */
    public static function convertPrice($amount, $fromCurrency, $toCurrency)
    {
        // Tỷ giá mẫu (nên lấy từ API thực tế như xe.com, fixer.io)
        $exchangeRates = [
            'JPY' => [
                'VND' => 165, // 1 JPY = 165 VND (tỷ giá mẫu)
                'USD' => 0.0067, // 1 JPY = 0.0067 USD
                'EUR' => 0.0061, // 1 JPY = 0.0061 EUR
                'CNY' => 0.048, // 1 JPY = 0.048 CNY
                'KRW' => 8.9, // 1 JPY = 8.9 KRW
            ],
            'VND' => [
                'JPY' => 0.006, // 1 VND = 0.006 JPY
                'USD' => 0.000041,
                'EUR' => 0.000037,
            ],
            // Thêm các tỷ giá khác...
        ];

        if ($fromCurrency === $toCurrency) {
            return $amount;
        }

        if (isset($exchangeRates[$fromCurrency][$toCurrency])) {
            return $amount * $exchangeRates[$fromCurrency][$toCurrency];
        }

        // Nếu không có tỷ giá trực tiếp, return original
        return $amount;
    }

    /**
     * Lấy currency mặc định
     */
    public static function getDefaultCurrency()
    {
        return config('app.default_currency', 'JPY');
    }
}
