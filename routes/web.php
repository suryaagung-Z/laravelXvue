<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/{any}', function (){
    return view('app');
})->where('any', '.*');

// Route::get('/', [Home::class, "show"]);

// Route::controller(ProductController::class)->group(function (){
//     Route::get('/product', "show");
//     Route::get('/product/add', "add");
//     Route::post('/product', "in")->name('product.in');
// });

// Route::get('/gallery', [Gallery::class, "show"]);

// Route::get('/contact', [Contact::class, "show"]);
