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

Route::get('/', [App\Http\Controllers\Front\LadderController::class, 'index'])->name('ladder.index');
Route::get('/ladders/{ladder}/ranking', [App\Http\Controllers\Front\LadderController::class, 'ranking'])->name('ladder.ranking');

Route::group(['prefix' => 'ajax'], function () {
    Route::get('ladders', [App\Http\Controllers\Ajax\LadderController::class, 'index'])->name('ajax.ladder.index');
    Route::get('ladders/{ladder}/ranking', [App\Http\Controllers\Ajax\LadderController::class, 'ranking'])->name('ajax.ladder.ranking');

    Route::group(['middleware' => ['auth', 'is.admin']], function () {
        Route::post('ladders', [App\Http\Controllers\Ajax\LadderController::class, 'store'])->name('api.ladder.store');
        Route::put('ladders/{ladder}', [App\Http\Controllers\Ajax\LadderController::class, 'update'])->name('api.ladder.update');
    });

    Route::get('ladders/{ladder}/teams', [App\Http\Controllers\Ajax\TeamController::class, 'index'])->name('ajax.team.index');
    Route::post('ladders/{ladder}/games', [App\Http\Controllers\Ajax\GameController::class, 'store'])->name('ajax.game.store');
});
