<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Endpoint Publik (Tanpa Token / Belum Login)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Endpoint yang Dilindungi Middleware Sanctum (Wajib bawa Bearer Token)
Route::middleware('auth:sanctum')->group(function () {
    // Autentikasi
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Buku Routes (Manajemen Buku)
    Route::get('/books', [BookController::class, 'index']);
    Route::post('/books', [BookController::class, 'store']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);

    // Peminjaman (Loan) Routes
    Route::get('/loans', [LoanController::class, 'index']);
    Route::post('/loans', [LoanController::class, 'store']);
});