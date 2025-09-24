<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SpecController;

// Auth
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected
Route::middleware(['jwt.auth'])->group(function () {
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/category/add', [CategoryController::class, 'store']);
    Route::delete('/category/{id}/delete', [CategoryController::class, 'destroy']);

    Route::get('/product/{categoryId}', [ProductController::class, 'getByCategory']);
    Route::post('/product', [ProductController::class, 'store']);
    Route::put('/product/{id}', [ProductController::class, 'update']);
    Route::delete('/product/{id}', [ProductController::class, 'destroy']);

    Route::get("/profile",[ProfileController::class,'show']);
    Route::put("/profile/edit",[ProfileController::class,'update']);

    Route::get("/service/{section}",[ServiceController::class,'index']);
    Route::post("/service/{id}/edit",[ServiceController::class,'update']);

    Route::get("/spec/{section}",[SpecController::class,'index']);
    Route::post("/spec/{id}/edit",[SpecController::class,'update']);

});

// Public
Route::get('/public/categories', [CategoryController::class, 'publicList']);
Route::get('/public/service/{section}', [ServiceController::class, 'index']);
Route::get('/public/spec/{section}', [SpecController::class, 'index']);
Route::get('/public/products/{categoryId}', [ProductController::class, 'publicByCategory']);

