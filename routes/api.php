<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\CuestionarioController;
use App\Http\Controllers\JuegoController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;

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

// routes/api.php
Route::middleware('auth:sanctum')->get('/get-token', [TokenController::class, 'getToken']);



Route::get('api/Temas', [CuestionarioController::class, 'apiTemas']);
