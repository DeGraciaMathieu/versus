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

Route::get('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::get('/', [\App\Http\Controllers\LadderController::class, 'index'])->name('ladder.index');
Route::get('/ladders/{ladder}/ranking', [\App\Http\Controllers\LadderController::class, 'ranking'])->name('ladder.ranking');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/ladders/{ladder}/teams/create', [\App\Http\Controllers\TeamController::class, 'create'])->name('team.create');
    Route::post('ladders/{ladder}/teams', [\App\Http\Controllers\TeamController::class, 'store'])->name('team.store');

    Route::group(['middleware' => 'team.registred'], function () {
        Route::get('ladders/{ladder}/games/create', [\App\Http\Controllers\GameController::class, 'create'])->name('game.create');
        Route::post('ladders/{ladder}/games', [\App\Http\Controllers\GameController::class, 'store'])->name('game.store');
    });

    Route::group(['middleware' => 'has.role:admin'], function () {
        Route::get('ladders/create', [\App\Http\Controllers\LadderController::class, 'create'])->name('ladder.create');
        Route::post('ladders', [\App\Http\Controllers\LadderController::class, 'store'])->name('ladder.store');
        Route::get('ladders/{ladder}/edit', [\App\Http\Controllers\LadderController::class, 'edit'])->name('ladder.edit');
        Route::put('ladders/{ladder}', [\App\Http\Controllers\LadderController::class, 'update'])->name('ladder.update');

        Route::get('games', [\App\Http\Controllers\GameController::class, 'index'])->name('game.index');
        Route::delete('games/{game}', [\App\Http\Controllers\GameController::class, 'destroy'])->name('game.destroy');
    });
});

Route::get('images/{image}', [\App\Http\Controllers\ImageController::class, 'show'])
    ->middleware('cache.headers:public;max_age=3600;etag')
    ->name('image');
