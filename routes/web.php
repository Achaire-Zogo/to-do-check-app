<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChecklistController;

Route::get('/', [ChecklistController::class, 'index'])->name('checklist.index');
Route::post('/api/checklist', [ChecklistController::class, 'store'])->name('checklist.store');
