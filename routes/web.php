<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShortenerController;

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
Route::get('/{hash}', [ShortenerController::class, 'process'])->middleware(['ipblock'])->name('process');
Route::post('shortlink', [ShortenerController::class, 'store'])->name('link.store');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
