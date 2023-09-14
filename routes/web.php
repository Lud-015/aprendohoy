<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\InscritosController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ForoController;
use App\Models\Cursos;
use App\Models\Inscritos;
use Database\Seeders\Administrador;

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
    return view('sign-in');
});







Route::post('/login', [UserController::class, 'authenticate'])->name('login.signin');





Route::group(['middleware' => ['auth']], function () {
    Route::get('/Miperfil', [UserController::class, 'UserProfile'])->name('Miperfil');
    Route::get('/user/{id}', [UserController::class, 'Profile']);
    Route::get('/EditarPerfil/{id}', [UserController::class, 'EditProfileIndex']);
    Route::post('/EditarPerfil/{id}', [UserController::class, 'UserProfileEdit'])->name('Editarperfil');

    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/Inicio', [MenuController::class, 'index'])->name('Inicio');

    Route::group(['middleware' => ['role:Administrador']], function () {

        Route::get('/EditarUsuario/{id}', [AdministradorController::class, 'EditUserIndex']);
        Route::post('/EditarUsuario/{id}', [AdministradorController::class, 'EditUser'])->name('Editarperfil');

        

        //Administrador/Docentes Rutas
        Route::get('/ListaDocente', [MenuController::class, 'ListaDocentes'])->name('ListaDocentes');
        Route::get('/CrearDocente', [MenuController::class, 'storeDIndex'])->name('CrearDocente');
        Route::post('/CrearDocente', [AdministradorController::class, 'storeDocente']);
        //Administrador/Cursos
        Route::get('/ListaCursos', [MenuController::class, 'ListaCursos'])->name('ListadeCursos');
        Route::get('/CrearCursos', [MenuController::class, 'storeCIndex'])->name('CrearCurso');
        Route::post('/CrearCursos', [AdministradorController::class, 'storeCurso']);
        Route::get('/EditarCurso/{id}', [CursosController::class, 'EditCIndex']);
        Route::post('/EditarCurso/{id}', [CursosController::class, 'EditC']);
        //Route::post('/CrearCursos', [CursosController::class, 'store'])->name('storeCursos');
        //Administrador/Estudiantes
        Route::get('/ListaEstudiante', [MenuController::class, 'ListaEstudiantes'])->name('ListaEstudiantes');
        Route::get('/CrearEstudiante', [MenuController::class, 'storeEIndex'])->name('CrearEstudiante');
        Route::post('/CrearEstudiante', [AdministradorController::class, 'storeEstudiante']);
        Route::get('/CrearEstudianteMenor', [MenuController::class, 'storeETIndex'])->name('CrearEstudianteMenor');
        Route::post('/CrearEstudianteMenor', [AdministradorController::class, 'storeEstudianteMenor']);
    });


    //DOCENTE
    Route::group(['middleware' => ['role:Docente|Administrador' ]], function () {

        //  Route::get('/Cursos/editar/{id}', [CursosController::class, 'index']);
        Route::get('CrearForo/cursoid={id}', [ForoController::class, 'Crearforo'])->name('CrearForo');
        Route::post('CrearForo/cursoid={id}', [ForoController::class, 'store']);
        Route::get('EditarForo/cursoid={id}', [ForoController::class, 'EditarForoIndex'])->name('CrearForo');
        Route::get('EditarForo/cursoid={id}', [ForoController::class, 'EditarForo']);



        Route::get('CrearRecurso/cursoid={id}', [RecursosController::class, 'indexRecurso'])->name('CrearRecursos');
        Route::get('CrearRecurso/cursoid={id}', [RecursosController::class, 'CrearRecurso'])->name('CrearRecursos');
        Route::get('ModificarRecurso/cursoid={id}', [RecursosController::class, 'ModificarRecursoIndex'])->name('CrearRecursos');
        Route::get('ModificarRecurso/cursoid={id}', [RecursosController::class, 'ModificarRecurso'])->name('CrearRecursos');



        Route::get('/AsignarCursos', [InscritosController::class, 'index'])->name('AsignarCurso');
        Route::post('/AsignarCursos', [InscritosController::class, 'store'])->name('inscribir');
        Route::get('listaParticipantes/cursoid={id}', [CursosController::class, 'listaCurso'])->name('listacurso');
    });
    //ENDDOCENTE

    //ESTUDIANTE
    Route::group(['middleware' => ['role:Estudiante|Docente|Administrador']], function () {

        Route::get('/Cursos/id/{id}', [CursosController::class, 'index'])->name('Curso');
        Route::get('/foro/id={id}', [ForoController::class, 'index'])->name('foro');
        Route::post('/foro/id={id}', [ForoController::class, 'storeMensaje']);
        Route::get('VerRecursos/cursoid={id}', [RecursosController::class, 'showRecurso'])->name('VerRecursos');
    //ENDESTUDIANTE


        //CAMBIARcONTRASEÑA
        Route::get('CambiarContraseña', [UserController::class, 'EditContraseñaIndex'])->name('CambiarContraseña');
        Route::post('CambiarContraseña', [UserController::class, 'CambiarContraseña']);
    });

});
