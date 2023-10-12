<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\NotifyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [NotifyController::class, 'index'])->name('index');
Route::resource('notify', NotifyController::class)->only(['show', 'create', 'store', 'update', 'destroy']);
Route::resource('content', ContentController::class)->only(['store', 'destroy']);
Route::resource('category', CategoryController::class);
