<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToolController;

Route::get('/', function () {
    return view('welcome'); // Or the correct home page view
})->name('home');

Route::get('/tool', [ToolController::class, 'index'])->name('KDTool');
Route::post('/tool/calculate-and-get-density', [ToolController::class, 'CalculateAndGetDensity']);
Route::post('/tool/export-results', [ToolController::class, 'exportResults'])->name('tool.export');
