<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/')->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('main');

    Route::get('/favorite/{product}', [FavoriteController::class, 'store'])->name('favorite.store');
    Route::delete('/favorite/{product}', [FavoriteController::class, 'destroy'])->name('favorite.delete');

    Route::get('categories/{id}', [CategoryController::class, 'index'])->name('category.index');

    Route::get('products/{id}', [ProductController::class, 'index'])->name('product.index');

    Route::post('reviews', [ReviewController::class, 'store'])->name('review.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
