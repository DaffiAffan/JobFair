<?php

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ParticipantController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/scan', [AttendanceController::class, 'scan']);
Route::apiResource('participants', ParticipantController::class);
