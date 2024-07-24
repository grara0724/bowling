<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScoreCalculationController;

Route::get('/', function () {
    return view('index');
});

Route::post('calc', [ScoreCalculationController::class, 'calc'])->name('calc');
