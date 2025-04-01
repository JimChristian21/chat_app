<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('chat/{id}', [ChatController::class, 'get'])->middleware(['auth'])->name('chat.get');
Route::post('chat/{id}', [ChatController::class, 'store'])->middleware(['auth'])->name('chat.store');

Route::patch('chat/typing/{id}', [ChatController::class, 'typing'])->middleware(['auth'])->name('chat.typing');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
