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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/ladders/{ladder}/teams/create', [\App\Http\Controllers\TeamController::class, 'create'])->name('team.create');
    Route::post('ladders/{ladder}/teams', [\App\Http\Controllers\TeamController::class, 'store'])->name('team.store');

    Route::group(['middleware' => 'team.registred'], function () {
        Route::get('ladders/{ladder}/games/create', [\App\Http\Controllers\GameController::class, 'create'])->name('game.create');
        Route::post('ladders/{ladder}/games', [\App\Http\Controllers\GameController::class, 'store'])->name('game.store');
    });

    Route::group(['middleware' => 'is.admin'], function () {
        Route::post('ladders', [\App\Http\Controllers\LadderController::class, 'store'])->name('ladder.store');
        Route::put('ladders/{ladder}', [\App\Http\Controllers\LadderController::class, 'update'])->name('ladder.update');
    });
});
