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

Route::get('/{any}', 'App\Http\Controllers\PageController@index')->where('any', '.*');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::post('/tokenRefresh', [App\Http\Controllers\AuthController::class, 'refresh']);
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);
    Route::get('/user-profile', [App\Http\Controllers\AuthController::class, 'userProfile']);

    Route::post('/addPokemon', [App\Http\Controllers\PokemonController::class, 'updatePokemonUser']);
    Route::post('/retrieveLikeHateFave', [App\Http\Controllers\PokemonController::class, 'retrieveLikeHateFav']);
    Route::get('/retrievePokemon', [App\Http\Controllers\PokemonController::class, 'retrieveAllUserPokemon']);
});
