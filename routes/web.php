<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\ReceptionController;

Route::get('/', [ReceptionController::class, 'index'])->name('reception.index');
Route::post('/reception/store', [ReceptionController::class, 'store'])->name('reception.store');
Route::get('/checklist', [ChecklistController::class, 'index'])->name('checklist.index');
Route::post('/api/checklist', [ChecklistController::class, 'store'])->name('checklist.store');
