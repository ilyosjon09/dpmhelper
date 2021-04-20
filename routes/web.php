<?php

use App\Http\Controllers\PinflController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/', [PinflController::class, 'index'])->name('main');
Route::post('/', [PinflController::class, 'toggleAttached'])->name('toggle-attach');
// Route::get('/', [PinflController::class, 'filter']);
require __DIR__.'/auth.php';
