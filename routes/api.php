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
use App\Http\Controllers\RiskHandlingController;


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
    Route::delete('/risk-analysis/{id}', [RiskAnalysisController::class, 'delete']);
    Route::get('/risk-analysis/pending-and-approved', [RiskAnalysisController::class,'getPendingAndApproved']);
    Route::get('/risk-analysis/{id}', [RiskAnalysisController::class, 'getById']);

     // =====================
    // NOTIFICATIONS ENDPOINT
    // =====================
    Route::get('/notifications', function (Request $request) {
      return $request->user()->notifications;
  });

    // =====================
    // RISK VALIDATION ENDPOINT
    // =====================
    Route::get('/risk-validations/validated', [RiskValidationController::class, 'getValidatedRisks']);
    Route::post('/risks/{id}/validate', [RiskValidationController::class, 'validateRisk']);
        // =====================


    // RISK APPETITE ENDPOINT
    // =====================
    Route::post('/risk-appetite', [RiskAppetiteController::class, 'store']);
    Route::patch('/risk-appetite/{id}/decision', [RiskAppetiteController::class, 'updateDecision']);
    Route::put('/risk-appetite/{id}/controllability', [RiskAppetiteController::class, 'updateControllability']);


        // =====================
    // RISK MITIGATIONS ENDPOINT
    // =====================
    Route::post('/risk-mitigations', [RiskMitigationController::class, 'store']);
    Route::get('/risk-mitigations', [RiskMitigationController::class, 'index']);
    Route::get('/risk-mitigations/risk/{riskId}', [RiskMitigationController::class, 'getMitigationsByRiskId']);
    Route::get('/risk-mitigations/{id}', [RiskMitigationController::class, 'show']);
    Route::put('/risk-mitigations/{id}', [RiskMitigationController::class, 'update']);
    Route::delete('/risk-mitigations/{id}', [RiskMitigationController::class, 'destroy']);

    // general endpoin API
    Route::get('/risk-analysis/by-risk/{riskId}/complete', [RiskAnalysisController::class, 'getCompleteByRiskId']);

    // =====================
    // RISK HANDLING ENDPOINT
    // =====================
    Route::post('/risk-handlings', [RiskHandlingController::class, 'store']);
    Route::post('/risk-handlings/{id}/send', [RiskHandlingController::class, 'sendToKepala']);
    Route::post('/risk-handlings/{id}/review', [RiskHandlingController::class, 'reviewHandling']);
    Route::get('/risk-handlings', [RiskHandlingController::class, 'getAll']);
    Route::put('/risk-handlings/{id}', [RiskHandlingController::class, 'update']);
    Route::delete('/risk-handlings/{id}', [RiskHandlingController::class, 'destroy']);
});
