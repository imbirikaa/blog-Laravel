<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\Homepage;

Route::get('/', [Homepage::class, 'index'])->name('homepage');
Route::get('/sayfa', [Homepage::class, 'index'])->name('paginate');
Route::get('/iletisim', [Homepage::class, 'contact'])->name('contact');
Route::post('/iletisim', [Homepage::class, 'contactPost'])->name('contact.post');
Route::get('/kategori/{cat}', [Homepage::class, 'category'])->name('category');
Route::get('/{cat}/{slug}', [Homepage::class, 'single'])->name('single');
Route::get('/{page}', [Homepage::class, 'page'])->name('page');
