<?php

use Illuminate\Support\Facades\Route;
use Modules\Mahasiswa\Http\Controllers\MahasiswaController;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
    Route::get('mahasiswa/data', [MahasiswaController::class, 'getData'])->name('mahasiswa.data'); 
    Route::post('mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');  
    Route::get('mahasiswa/{id}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
    Route::delete('mahasiswa/{id}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');

});
