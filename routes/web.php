<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ======== PROFILE (default breeze) ========
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ======== USER DAN UPLOAD ========
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::post('/upload', [UploadController::class, 'store'])->name('upload.store');
Route::delete('/upload/{upload}', [UploadController::class, 'destroy'])->name('upload.destroy');

// ======== MAHASISWA ========
// Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
// Route::get('/mahasiswa/data', [MahasiswaController::class, 'getData'])->name('mahasiswa.data');
// Route::post('/mahasiswa/store', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
// Route::get('/mahasiswa/edit/{id}', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
// Route::put('/mahasiswa/update/{id}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
// Route::delete('/mahasiswa/delete/{id}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');

require __DIR__.'/auth.php';
