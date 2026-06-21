<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\SocialLink;
use App\Models\User;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'products' => Product::count(),
                'categories' => Category::count(),
                'brands' => Brand::count(),
                'sliders' => Slider::count(),
                'orders' => Order::count(),
                'users' => User::count(),
                'settings' => Setting::count(),
                'social links' => SocialLink::count(),
            ],
        ]);
    }
}
