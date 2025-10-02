<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::middleware('throttle:login')->post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function(){
    Route::apiResource('/authors', AuthorController::class);
    Route::apiResource('/books', BookController::class);
    Route::apiResource('/members', MemberController::class);
    Route::apiResource('/borrowings', BorrowingController::class)->only(['index','show', 'store']);
    Route::post('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook']);
    Route::get('/borrowings/overdue/list', [BorrowingController::class, 'overdue']);
    Route::get('/statistics', [StatisticsController::class, 'statistic']);
    Route::post('/logout', [AuthController::class, 'logout']);

});