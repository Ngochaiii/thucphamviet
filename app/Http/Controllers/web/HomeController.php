<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        // Lấy categories để truyền cho view
        $categories = Category::with(['children' => function ($query) {
            $query->where('is_active', true)->orderBy('sort_order');
        }])
        ->where('is_active', true)
        ->whereNull('parent_id')
        ->orderBy('sort_order')
        ->get();

        return view('src.web.home.index',compact('categories'));
    }
}
