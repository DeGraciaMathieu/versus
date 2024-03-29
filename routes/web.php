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
Route::get('/ladders/{ladder}/games', [\App\Http\Controllers\GameController::class, 'index'])->name('game.index');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/ladders/{ladder}/teams/create', [\App\Http\Controllers\TeamController::class, 'create'])->name('team.create');
    Route::post('ladders/{ladder}/teams', [\App\Http\Controllers\TeamController::class, 'store'])->name('team.store');

    Route::group(['middleware' => 'team.registered'], function () {
        Route::get('ladders/{ladder}/games/create', [\App\Http\Controllers\GameController::class, 'create'])->name('game.create');
        Route::post('ladders/{ladder}/games', [\App\Http\Controllers\GameController::class, 'store'])->name('game.store');
    });

    Route::delete('ladders/{ladder}/games/{game}', [\App\Http\Controllers\GameController::class, 'destroy'])
        ->name('game.destroy')
        ->middleware('can:delete,game');

    Route::get('ladders/create', [\App\Http\Controllers\LadderController::class, 'create'])
        ->name('ladder.create')
        ->middleware('can:create,App\Models\Ladder');

    Route::post('ladders', [\App\Http\Controllers\LadderController::class, 'store'])
        ->name('ladder.store')
        ->middleware('can:create,App\Models\Ladder');

    Route::get('ladders/{ladder}/edit', [\App\Http\Controllers\LadderController::class, 'edit'])
        ->name('ladder.edit')
        ->middleware('can:update,ladder');

    Route::put('ladders/{ladder}', [\App\Http\Controllers\LadderController::class, 'update'])
        ->name('ladder.update')
        ->middleware('can:update,ladder');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])
        ->name('user.index')
        ->middleware('can:viewAny,App\Models\User');

    Route::get('users/{user}/edit', [\App\Http\Controllers\UserController::class, 'edit'])
        ->name('user.edit')
        ->middleware('can:update,user');

    Route::put('users/{user}', [\App\Http\Controllers\UserController::class, 'update'])
        ->name('user.update')
        ->middleware('can:update,user');

    Route::get('home/settings', [\App\Http\Controllers\HomeController::class, 'settings'])
        ->name('home.settings');

    Route::put('home/settings', [\App\Http\Controllers\HomeController::class, 'updateSettings'])
        ->name('home.updateSettings');
});

Route::get('images/{image}', [\App\Http\Controllers\ImageController::class, 'show'])
    ->middleware('cache.headers:public;max_age=3600;etag')
    ->name('image');
