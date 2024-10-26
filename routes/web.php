<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\Homepage;
use App\Http\Controllers\Back\Dashboard;
use App\Http\Controllers\Back\AuthController;
use App\Http\Controllers\Back\ArticleController;
use App\Http\Controllers\Back\CategoryController;
use App\Models\Category;

//======================Back Routes

route::prefix('admin')->middleware('isLogin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'loginPost'])->name('login.post');
});

route::prefix('admin')->middleware('isAdmin')->name('admin.')->group(function () {
    Route::get('panel', [Dashboard::class, 'index'])->name('dashboard');
    // Makale ROUTEs
    Route::get('makaleler/silinenler', [ArticleController::class,'trashed'])->name('trashed.article');
    Route::resource('makaleler',ArticleController::class);
    Route::get('/switch', [ArticleController::class,'switch'])->name('switch');
    Route::get('/deletearticle/{id}', [ArticleController::class,'delete'])->name('delete.article');
    Route::get('/harddeletearticle/{id}', [ArticleController::class,'harddelete'])->name('hard.delete.article');
    Route::get('/recoverarticle/{id}', [ArticleController::class,'recover'])->name('recover.article');
    // Kategori ROUTES
    Route::get('/kategoriler',[CategoryController::class,'index'])->name('category.index');
    Route::post('/kategoriler/create',[CategoryController::class,'create'])->name('category.create');
    Route::post('/kategoriler/update',[CategoryController::class,'update'])->name('category.update');
    Route::post('/kategoriler/delete',[CategoryController::class,'delete'])->name('category.delete');
    Route::get('/kategoriler/status',[CategoryController::class,'switch'])->name('category.switch');
    Route::get('/kategoriler/getData',[CategoryController::class,'getData'])->name('category.getData');
    //
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

});



//======================Front Routes
Route::get('/', [Homepage::class, 'index'])->name('homepage');
Route::get('/sayfa', [Homepage::class, 'index'])->name('paginate');
Route::get('/iletisim', [Homepage::class, 'contact'])->name('contact');
Route::post('/iletisim', [Homepage::class, 'contactPost'])->name('contact.post');
Route::get('/kategori/{cat}', [Homepage::class, 'category'])->name('category');
Route::get('/{cat}/{slug}', [Homepage::class, 'single'])->name('single');
Route::get('/{page}', [Homepage::class, 'page'])->name('page');
