<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::middleware('throttle:api')->group(function () {
    Route::get('profile/skills', [ProfileController::class, 'skills']);
    Route::get('profile/specialties', [ProfileController::class, 'specialties']);
});
Route::post('/contact', [ContactController::class, 'send'])->middleware('throttle:contact-limiter');
