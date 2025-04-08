<?php

use App\Http\Controllers\Apis\V1\UploadController;
use App\Http\Controllers\Web\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/uploads/cloundinary', [UploadController::class, 'uploadCloundinary']);