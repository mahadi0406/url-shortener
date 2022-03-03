<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShortenerController;
use App\Http\Controllers\HomeController;

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

Route::get('/', [ShortenerController::class, 'create'])->name('create');
Route::get('report', [ShortenerController::class, 'report'])->name('report');
Route::post('shortlink', [ShortenerController::class, 'store'])->name('link.store');
Route::get('export', [ShortenerController::class, 'export'])->name('export');


Route::get('dashboard', [HomeController::class, 'index'])->middleware(['auth'])->name('dashboard');
require __DIR__.'/auth.php';
Route::get('/{hash}', [ShortenerController::class, 'process'])->middleware(['ipblock'])->name('process');
