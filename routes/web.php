<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EncartController;

Route::get('/', [EncartController::class, 'index'])->name('encarts.index');
Route::get('/create', [EncartController::class, 'create'])->name('encarts.create');
Route::post('/store', [EncartController::class, 'store'])->name('encarts.store');
Route::delete('/encarts/{id}', [EncartController::class, 'destroy'])->name('encarts.destroy');

