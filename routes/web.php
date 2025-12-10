<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Products;

Route::get('/products', Products::class)->name('products');