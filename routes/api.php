<?php

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ParticipantController;

Route::post('/inipunyaklaten', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(
    function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
    }
);

Route::get('/attendances', [AttendanceController::class, 'index']);
Route::post('/scan', [AttendanceController::class, 'scan']);
Route::apiResource('participants', ParticipantController::class);
