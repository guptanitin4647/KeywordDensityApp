<?php
use App\Http\Controllers\ToolController;
use Illuminate\Support\Facades\Route;

Route::get('/tool', [ToolController::class, 'index'])->name('KDTool');
Route::post('/tool/calculate-and-get-density', [ToolController::class, 'CalculateAndGetDensity']);