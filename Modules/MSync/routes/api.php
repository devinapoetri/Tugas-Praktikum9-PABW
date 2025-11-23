<?php

use Illuminate\Support\Facades\Route;
use Modules\MSync\Http\Controllers\MSyncController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('msyncs', MSyncController::class)->names('msync');
});
