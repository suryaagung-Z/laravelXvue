<?php

use App\Http\Controllers\Api\RequestAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::controller(RequestAPI::class)->group(function () {
    // Get all products
    Route::get('/products', 'products');
    // Get by id
    Route::get('/products/id/{id}', 'prodByIdOrFails');
    // Get all by category
    Route::get('/products/with/category', 'productsWithCategory');
    // Get it all in the trash
    Route::get('/products/trash', 'productsInTrash');

    // Store data
    Route::post('/products/add', 'store');
    // Update data
    Route::put('/products/update', 'update');
    // Undo from trash
    Route::put('/products/undo', 'undo');
    // Delete data
    Route::delete('/products/del/{id}/{soft}', 'delete');

    // Get all categories
    Route::get('/categories', 'categories');
});
