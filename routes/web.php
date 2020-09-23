<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SymptomController;
use App\Http\Controllers\ShareController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth:sanctum', 'verified'])->get('/', [SymptomController::class, 'create'])->name('tracker');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Route::resource('symptoms','App\Http\Controllers\SymptomController');

/*
| symptom routes
*/
Route::middleware(['auth:sanctum', 'verified'])->get('/reports', [SymptomController::class, 'index'])->name('symptom.reports');
Route::middleware(['auth:sanctum', 'verified'])->get('/add', [SymptomController::class, 'create']);
Route::middleware(['auth:sanctum', 'verified'])->get('/edit/{id}', [SymptomController::class, 'edit']);
Route::middleware(['auth:sanctum', 'verified'])->post('/store', [SymptomController::class, 'store'])->name('new_entry');
Route::middleware(['auth:sanctum', 'verified'])->post('/update/$id}', [SymptomController::class, 'update'])->name('update');
Route::middleware(['auth:sanctum', 'verified'])->post('/destroy/{id}', [SymptomController::class, 'destroy'])->name('symptom.destroy');

/*
| share routes
*/
Route::middleware(['auth:sanctum', 'verified'])->get('/shares', [ShareController::class, 'index'])->name('share.index');
Route::middleware(['auth:sanctum', 'verified'])->post('/share/store', [ShareController::class, 'store'])->name('share.store');
Route::middleware(['auth:sanctum', 'verified'])->post('/share/destroy/{id}', [ShareController::class, 'destroy'])->name('share.destroy');
Route::get('/v/{token}', [ShareController::class, 'view'])->name('share.view');