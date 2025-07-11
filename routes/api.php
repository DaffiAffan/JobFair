<?php

use App\Http\Controllers\ParticipantController;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource('participants', ParticipantController::class);
