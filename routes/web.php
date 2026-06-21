<?php

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PublicStorageController;
use App\Http\Controllers\Storefront\CategoryController;
use App\Http\Controllers\Storefront\HomeController;
use App\Http\Controllers\Storefront\ProductController;
use App\Http\Controllers\Storefront\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/storage/{path}', PublicStorageController::class)->where('path', '.*')->name('storage.public');
Route::get('/language/{locale}', LocaleController::class)->name('locale.switch');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/search/suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');

Route::view('/about', 'storefront.about')->name('about');
Route::view('/contact', 'storefront.contact')->name('contact');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
