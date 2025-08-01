<?php
// app/Providers/ViewServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Chỉ áp dụng cho sidebar component
        View::composer('components.sidebar', function ($view) {
            $categories = Category::with(['children' => function ($query) {
                $query->where('is_active', true)->orderBy('sort_order');
            }])
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

            $view->with('categories', $categories);
        });
    }

    public function register()
    {
        //
    }
}
