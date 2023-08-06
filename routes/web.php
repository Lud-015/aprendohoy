<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\Menu;

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

Route::get('/login', function () {
    return view('login');
});




Route::post('/login', [UserController::class, 'authenticate'])->name('login.signin');





Route::group(['middleware' => ['auth']], function() { 
    
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/Inicio', [Menu::class, 'index'])->name('Inicio');
    
    Route::group(['middleware' => ['role:Administrador']], function () {
    //Administrador/Docentes Rutas    
    Route::get('/ListaDocente', [Menu::class, 'ListaDocentes'])->name('ListaDocentes');
    Route::get('/CrearDocente', [Menu::class, 'storeDIndex'])->name('CrearDocente');
    Route::post('/CrearDocente', [AdministradorController::class, 'storeDocente']);
    Route::get('/BloquearDocente/{$id}', [AdministradorController::class, 'blockDocente']);
    Route::get('/ModificarDocente/{$id}', [MenuController::class, 'editIndexDocente']);
    Route::post('/ModificarDocente/{$id}', [DocenteController::class, 'editDocente']);
    //Administrador/Cursos
    Route::get('/ListaCursos', [Menu::class, 'ListaCursos'])->name('ListadeCursos');
    Route::get('/CrearCursos', [Menu::class, 'storeCIndex'])->name('CrearCurso');
    Route::post('/CrearCursos', [AdministradorController::class, 'storeCurso']);
    //Route::post('/CrearCursos', [CursosController::class, 'store'])->name('storeCursos');

    
    




    });


    Route::group(['middleware' => ['role:Docente']], function () {

    Route::get('/Cursos/id/{id}', [CursosController::class, 'index'])->name('Curso');
    


    });




});