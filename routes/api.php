<?php

use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('user/register', [UserController::class, 'register']);
Route::post('user/login', [UserController::class, 'login']);
Route::group(['prefix' => '/user', 'middleware' => ['auth:sanctum']], function () {
    Route::get('profil/{id}', [UserController::class, 'profil']);
    Route::post('update', [UserController::class, 'update']);

    Route::get('logout', [UserController::class, 'logout']);
});

//Barang
Route::get('/barang', [BarangController::class, 'index']);
Route::get('/barang/detail/{id}', [BarangController::class, 'detail']);
Route::get('/barang/cari', [BarangController::class, 'cari']);

Route::group(['prefix' => '/order', 'middleware' => ['auth:sanctum']], function () {
    Route::post('/store', [OrderController::class, 'store']);
    Route::get('/listpesanan/{id}', [OrderController::class, 'history']);
});
