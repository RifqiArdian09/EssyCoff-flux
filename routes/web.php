<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\Categories\{Index as CategoriesIndex, Create as CategoriesCreate, Edit as CategoriesEdit};
use App\Livewire\Products\{Index as ProductsIndex, Create as ProductsCreate, Edit as ProductsEdit};


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

// Routes untuk kategori
Route::get('/categories', CategoriesIndex::class)->name('categories.index')->middleware('auth');
Route::get('/categories/create', CategoriesCreate::class)->name('categories.create')->middleware('auth');
Route::get('/categories/{category}/edit', CategoriesEdit::class)->name('categories.edit')->middleware('auth');

// Routes untuk produk
Route::get('/products', ProductsIndex::class)->name('products.index')->middleware('auth');
Route::get('/products/create', ProductsCreate::class)->name('products.create')->middleware('auth');
Route::get('/products/{product}/edit', ProductsEdit::class)->name('products.edit')->middleware('auth');

// routes/web.php
Route::get('/pos', \App\Livewire\PosSystem::class)
    ->middleware(['auth'])
    ->name('pos.index');


require __DIR__.'/auth.php';
