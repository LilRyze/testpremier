<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get_teams', [ActionController::class, 'getTeams']);
Route::get('/get_results', [ActionController::class, 'getResults']);
Route::post('/play_one', [ActionController::class, 'playOne']);
Route::get('/play_all', [ActionController::class, 'playAll']);
