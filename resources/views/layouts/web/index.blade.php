<!DOCTYPE html>
<html lang="en">
<head>
    <title>Thực phẩm việt </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts.web.layouts.header_css')
    @stack('header_css')
</head>
<body>
@include('layouts.web.layouts.svg')
@include('layouts.web.layouts.sidebar')
@include('layouts.web.layouts.header')
@include('layouts.web.layouts.banner')
    @yield('content')
@include('layouts.web.layouts.footer')
@include('layouts.web.layouts.footer_js')
@include('layouts.web.layouts.cart')
@include('layouts.web.layouts.icon')
@stack('footer_js')
</body>
</html>
