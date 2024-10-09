<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EncartController;
use App\Http\Controllers\TagController;

Route::resource('encarts', EncartController::class);
Route::resource('tags', TagController::class);

Route::get('/', [EncartController::class, 'index'])->name('encarts.index');
Route::get('/create', [EncartController::class, 'create'])->name('encarts.create');
Route::post('/store', [EncartController::class, 'store'])->name('encarts.store');
Route::delete('/encarts/{id}', [EncartController::class, 'destroy'])->name('encarts.destroy');

