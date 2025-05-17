<?php

use App\Http\Controllers\Api\V1\PatientController;
use App\Http\Middleware\VerifyAccessKey;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware(VerifyAccessKey::class)->group(function () {
    Route::apiResource('patients', PatientController::class)->except(['create', 'edit']);
});
