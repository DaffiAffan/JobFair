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

        Route::get('/participants', [ParticipantController::class, 'index']);
        Route::get('/participants/{id}', [ParticipantController::class, 'show']);
        Route::put('/participants/{id}', [ParticipantController::class, 'update']);
        Route::delete('/participants/{id}', [ParticipantController::class, 'destroy']);

        Route::get('/attendances', [AttendanceController::class, 'index']);
        Route::post('/scan', [AttendanceController::class, 'scan']);
    }

);

Route::post('/participants', [ParticipantController::class, 'store']);
