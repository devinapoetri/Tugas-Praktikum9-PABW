<?php

use Illuminate\Support\Facades\Route;
use Modules\MSync\Http\Controllers\MSyncController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('msyncs', MSyncController::class)->names('msync');
});
