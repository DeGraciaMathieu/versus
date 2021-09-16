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

Route::get('/forgot-password', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [\App\Http\Controllers\Auth\NewPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [\App\Http\Controllers\Auth\NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.update');

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
});

Route::get('images/{image}', [\App\Http\Controllers\ImageController::class, 'show'])
    ->middleware('cache.headers:public;max_age=3600;etag')
    ->name('image');
