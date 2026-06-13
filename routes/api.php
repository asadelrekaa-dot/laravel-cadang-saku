<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BeriPinjamanController;
use App\Http\Controllers\Api\BudgetController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\HutangController;
use App\Http\Controllers\Api\IncomeController;
use App\Http\Controllers\Api\OutcomeController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/user', [AuthController::class, 'getProfile'])->middleware('auth:sanctum');
Route::put('/user', [AuthController::class, 'updateProfile'])->middleware('auth:sanctum');
Route::put('/user/password', [AuthController::class, 'updatePassword'])->middleware('auth:sanctum');
Route::post('/user/photo', [AuthController::class, 'updatePhoto'])->middleware('auth:sanctum');

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout'])->middleware('auth:sanctum');
Route::post('/google-login', [AuthController::class, 'googleLogin']);

Route::post('/wallet', [WalletController::class,'createWallet'])->middleware('auth:sanctum');
Route::get('/wallets', [WalletController::class, 'index'])->middleware('auth:sanctum');
Route::delete('/wallets/{id}', [WalletController::class, 'destroy'])->middleware('auth:sanctum');
Route::get('/category-income', [CategoryController::class,'indexIncome']);
Route::get('/category-outcome', [CategoryController::class,'indexOutcome']);
Route::post('/income',[IncomeController::class,'createIncome'])->middleware('auth:sanctum');
Route::put('/income/{id}', [IncomeController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/income/{id}', [IncomeController::class, 'destroy'])->middleware('auth:sanctum');
Route::get('/income', [IncomeController::class, 'getIncome'])->middleware('auth:sanctum');
Route::post('/outcome',[OutcomeController::class,'createOutcome'])->middleware('auth:sanctum');
Route::put('/outcome/{id}', [OutcomeController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/outcome/{id}', [OutcomeController::class, 'destroy'])->middleware('auth:sanctum');
Route::get('/outcome', [OutcomeController::class, 'getOutcome'])->middleware('auth:sanctum');
Route::post('/hutang',[HutangController::class, 'createHutang'])->middleware('auth:sanctum');
Route::put('/hutang/{id}',[HutangController::class, 'updateStatusHutang'])->middleware('auth:sanctum');
Route::delete('/hutang/{id}', [HutangController::class, 'destroy'])->middleware('auth:sanctum');
Route::get('/hutang', [HutangController::class, 'getHutang'])->middleware('auth:sanctum');
Route::post('/beri-pinjaman',[BeriPinjamanController::class, 'createBeriPinjaman'])->middleware('auth:sanctum');
Route::put('/beri-pinjaman/{id}', [BeriPinjamanController::class, 'updateStatusBeriPinjaman'])->middleware('auth:sanctum');
Route::delete('/beri-pinjaman/{id}', [BeriPinjamanController::class, 'destroy'])->middleware('auth:sanctum');
Route::get('/beri-pinjaman',[BeriPinjamanController::class, 'getBeriPinjaman'])->middleware('auth:sanctum');
Route::get('/budgets', [BudgetController::class, 'index'])->middleware('auth:sanctum');
Route::post('/budgets', [BudgetController::class, 'store'])->middleware('auth:sanctum');
Route::delete('/budgets/{id}', [BudgetController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/transactions', [TransactionController::class, 'index'])->middleware('auth:sanctum');
Route::get('/notifications', [NotificationController::class, 'index'])->middleware('auth:sanctum');