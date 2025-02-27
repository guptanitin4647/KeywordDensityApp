<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToolController;

Route::get('/tool', [ToolController::class, 'index'])->name('KDTool');
Route::post('/tool/calculate-and-get-density', [ToolController::class, 'calculateAndGetDensity']);
Route::get('/tools', [ToolController::class, 'index']);