<?php

use App\Http\Controllers\QRController;
use App\Http\Controllers\ScannerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

// QR Code Management Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('qr-codes', QRController::class);
    Route::get('qr-codes/{qrCode}/generate', [QRController::class, 'generate'])->name('qr-codes.generate');
});

// Scanner Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('scan', [ScannerController::class, 'scan']);
    Route::get('scan-history', [ScannerController::class, 'getScanHistory']);
});

// Public scanner route (for web scanner form)
Route::post('scan', [ScannerController::class, 'scan'])->middleware('web')->name('api.scan.public');

// Asset API Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('assets/{qrCode}', [App\Http\Controllers\AssetController::class, 'getByQrCode'])->name('api.assets.by-qr');
});

// Instrument Set API Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('instrument-sets/check-qr/{qrCode}', [App\Http\Controllers\InstrumentSetController::class, 'checkQrCode'])->name('api.instrument-sets.check-qr');
});

// Public route for QR checking (no auth required for lookup)
Route::get('instrument-sets/check-qr/{qrCode}', [App\Http\Controllers\InstrumentSetController::class, 'checkQrCode'])->name('api.instrument-sets.check-qr-public');
