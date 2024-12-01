<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

use App\Http\Controllers\CartController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
Route::post('/books/{book}/borrow', [BookController::class, 'borrow'])->name('books.borrow');
Route::post('/books/{book}/add-to-borrow-list', [BookController::class, 'addToBorrowList'])->name('books.addToBorrowList');



Route::middleware('auth')->group(function () {
    Route::post('/cart/{book}/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::delete('/cart/{cart}', [CartController::class, 'removeFromCart'])->name('cart.remove');
});



Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{bookId}', [CartController::class, 'addToCart'])->name('cart.add');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
