<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ApiAuthController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource('posts',PostController::class);

Route::post('register',[ApiAuthController::class ,'register']);
Route::post('login',[ApiAuthController::class ,'login']);
Route::post('logout',[ApiAuthController::class ,'logout'])->middleware('auth:sanctum');

// Route::get('/', function(){
//     return 'API';
// });