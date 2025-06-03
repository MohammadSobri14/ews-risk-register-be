<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\RiskController;
use App\Http\Controllers\RiskAnalysisController;
use App\Http\Controllers\RiskValidationController;
use App\Http\Controllers\RiskAppetiteController;
use App\Http\Controllers\RiskMitigationController;


// =====================
// AUTH ENDPOINTS
// =====================
Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh', [AuthController::class, 'refresh']);
Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // =====================
    // ADMIN USER ENDPOINTS
    // =====================
    Route::get('/users', [AdminUserController::class, 'index']);
    Route::post('/users', [AdminUserController::class, 'store']);
    Route::get('/users/{id}', [AdminUserController::class, 'show']);
    Route::put('/users/{id}', [AdminUserController::class, 'update']);
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy']);

    // =====================
    // RISK ENDPOINTS
    // =====================
    Route::apiResource('/risks', RiskController::class);

    // =====================
    // RISK ANALYSIS ENDPOINTS
    // =====================
    Route::post('/risk-analysis', [RiskAnalysisController::class, 'store']);
    Route::get('/risk-analysis', [RiskAnalysisController::class, 'getAll']);
    Route::post('/risk-analysis/{id}/send', [RiskAnalysisController::class, 'sendToManris']);
    Route::put('/risk-analysis/{id}', [RiskAnalysisController::class, 'update']);
    Route::get('/risk-analysis/{id}', [RiskAnalysisController::class, 'getById']);
    Route::delete('/risk-analysis/{id}', [RiskAnalysisController::class, 'delete']);

    // =====================
    // NOTIFICATIONS ENDPOINT
    // =====================
    Route::get('/notifications', function () {
      return auth()->user()->notifications;
  });

    // =====================
    // RISK VALIDATION ENDPOINT
    // =====================
    Route::post('/risks/{id}/validate', [RiskValidationController::class, 'validateRisk']);

        // =====================
    // RISK APPETITE ENDPOINT
    // =====================
    Route::post('/risk-appetite', [RiskAppetiteController::class, 'store']);

        // =====================
    // RISK MITIGATIONS ENDPOINT
    // =====================
    Route::post('/risk-mitigations', [RiskMitigationController::class, 'store']);
    Route::get('/risk-mitigations', [RiskMitigationController::class, 'index']);
    Route::get('/risk-mitigations/{id}', [RiskMitigationController::class, 'show']);
    Route::put('/risk-mitigations/{id}', [RiskMitigationController::class, 'update']);
    Route::delete('/risk-mitigations/{id}', [RiskMitigationController::class, 'destroy']);


});
