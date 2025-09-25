<?php

use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// added routes below
Route::get('/upload', [DocumentController::class, 'uploadForm'])->name('upload.form');
Route::post('/upload', [DocumentController::class, 'store'])->name('documents.store');
Route::get('/dashboard', [DocumentController::class, 'index'])->name('dashboard');
Route::get('/documents/{id}', [DocumentController::class, 'show'])->name('documents.show');
Route::post('/documents/{id}/revoke', [DocumentController::class, 'revoke'])->name('documents.revoke');
Route::post('/documents/{id}/unrevoke', [DocumentController::class, 'unrevoke'])->name('documents.unrevoke');
// public routes

Route::get('/verify/{id}', [DocumentController::class, 'verify'])->name('verify');
