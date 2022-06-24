<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{CategoryController, BookController,DashboardController};

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class,'index'])->name('dashboard');
    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');


    // CATEGORY
    Route::get('category', [CategoryController::class,'index'])->name('category');
    Route::post('storecategory', [CategoryController::class,'store'])->name('store_category');
    Route::get('destroy_category/{id}', [CategoryController::class,'destroy'])->name('destroy_category');
    Route::get('edit_category/{id}', [CategoryController::class,'edit'])->name('edit_category');
    Route::post('update_category', [CategoryController::class,'update'])->name('update_category');

    // BOOK
    Route::get('book', [BookController::class,'index'])->name('book');
    Route::post('storebook', [BookController::class,'store'])->name('store_book');
    Route::get('destroy_book/{id}', [BookController::class,'destroy'])->name('destroy_book');
    Route::get('edit_book/{id}', [BookController::class,'edit'])->name('edit_book');
    Route::post('update_book', [BookController::class,'update'])->name('update_book');
});

require __DIR__.'/auth.php';
