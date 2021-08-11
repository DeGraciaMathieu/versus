<?php

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

Auth::routes();

Route::get('/', [\App\Http\Controllers\LadderController::class, 'index'])->name('ladder.index');
Route::get('/ladders/{ladder}/ranking', [\App\Http\Controllers\LadderController::class, 'ranking'])->name('ladder.ranking');

Route::group(['middleware' => ['auth', 'is.admin']], function () {
    Route::post('ladders', [\App\Http\Controllers\LadderController::class, 'store'])->name('ladder.store');
    Route::put('ladders/{ladder}', [\App\Http\Controllers\LadderController::class, 'update'])->name('ladder.update');
});

Route::post('ladders/{ladder}/games', [\App\Http\Controllers\GameController::class, 'store'])->name('game.store');
