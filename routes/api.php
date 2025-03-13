<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\CuestionarioController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\CursosController;
use App\Models\Inscritos;
use Laravel\Sanctum\Sanctum;
use App\Http\Controllers\Api\DocenteController;
use App\Http\Controllers\Api\EstudianteController;
use App\Models\Cursos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('/getEstudiantesNoInscritos/{curso_id}', [Inscritos::class, 'getEstudiantesNoInscritos']);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [AuthController::class, 'registerEstudiante']);
Route::post('login', [AuthController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum']], function(){


   Route::post('user-profile', [AuthController::class, 'UserProfile']);
   Route::post('user-profile-edit', [AuthController::class, 'UserProfileEdit']);
   Route::post('usuario/{id}', [AuthController::class, 'show']);
   Route::post('logout', [AuthController::class, 'logout']);
   Route::group(['middleware' => ['role:Administrador']], function () {




   Route::post('registrarEstudiante', [EstudianteController::class, 'registerEstudiante']);
   Route::post('registrarEstudianteMenor', [EstudianteController::class, 'registerEstudianteMenor']);


   Route::post('registrarDocente', [DocenteController::class, 'registerDocente']);
   Route::post('ListadeDocentes', [DocenteController::class, 'index']);

   Route::post('registrarCursos', [CursosController::class, 'store']);



      Route::group(['middleware' => ['role:Docente']], function () {
         Route::group(['middleware' => ['role:Estudiante']], function () {





         });

      });

   });


});


