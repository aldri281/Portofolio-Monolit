<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\CertificateController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth
Route::post('/login', [AuthController::class, 'login']);

Route::get('/profile', [ProfileController::class, 'index']);
Route::get('/settings', [\App\Http\Controllers\SiteSettingController::class, 'index']);
Route::apiResource('projects', ProjectController::class)->only(['index', 'show']);
Route::apiResource('skills', SkillController::class)->only(['index', 'show']);
Route::apiResource('certificates', CertificateController::class)->only(['index', 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/profile', [ProfileController::class, 'update']);
    Route::post('/settings', [\App\Http\Controllers\SiteSettingController::class, 'update']);
    Route::apiResource('projects', ProjectController::class)->except(['index', 'show']);
    Route::apiResource('skills', SkillController::class)->except(['index', 'show']);
    Route::apiResource('certificates', CertificateController::class)->except(['index', 'show']);
});
