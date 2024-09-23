<?php

use App\Http\Controllers\Admin\ApiIndotekController;
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

Route::post('/v1/decrypt', [ApiIndotekController::class, 'decrypt']);
Route::post('/v1/sessionId', [ApiIndotekController::class, 'getSessionId']);
Route::post('/v1/GetGroupList', [ApiIndotekController::class, 'getGroupList']);
Route::post('/v1/GetGroupPolList', [ApiIndotekController::class, 'getGroupPolList']);
Route::post('/v1/GetGroupPolicyUserList', [ApiIndotekController::class, 'getGroupPolicyUserList']);
