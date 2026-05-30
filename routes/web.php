<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgeCalculatorController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/app', [AgeCalculatorController::class, 'index'])
    ->name('calculator');

Route::post('/calculate', [AgeCalculatorController::class, 'calculate'])
    ->name('calculate');
