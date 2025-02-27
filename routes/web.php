<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToolController;

Route::get('/', function () {
    return view('welcome'); // Set welcome page as the home page
})->name('home');

Route::get('/tool', [ToolController::class, 'index'])->name('KDTool');
Route::post('/tool/calculate-and-get-density', [ToolController::class, 'CalculateAndGetDensity']);