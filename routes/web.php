<?php

use App\Http\Controllers\MarketingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MarketingController::class, 'home'])->name('home');
Route::get('/features', [MarketingController::class, 'features'])->name('features');
Route::get('/workflow', [MarketingController::class, 'workflow'])->name('workflow');
Route::get('/pricing', [MarketingController::class, 'pricing'])->name('pricing');
Route::get('/demo', [MarketingController::class, 'demo'])->name('demo');
