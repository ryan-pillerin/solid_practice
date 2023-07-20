<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/** No Sanctum Testing */
Route::post('/register_user', [App\Http\Controllers\API\Users\UsersController::class, 'register_user']);
Route::get('/get_all_users/{id?}', [App\Http\Controllers\API\Users\UsersController::class, 'get_all_users']);
