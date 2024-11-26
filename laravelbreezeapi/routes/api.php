<?php

use Illuminate\Http\Request;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function(){
    Route::apiResource('users', UserController::class);
});

Route::middleware('auth:api')->post('/upload-profile', [UserController::class, 'uploadProfile']);
