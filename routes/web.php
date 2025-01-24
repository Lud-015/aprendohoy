<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\AportesController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\RecursosController;
use App\Http\Controllers\InscritosController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ForoController;
use App\Http\Controllers\TareasController;
use App\Http\Controllers\TareasEntregaController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\BoletinController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\CuestionarioController;
use App\Http\Controllers\EdadDirigidaController;
use App\Http\Controllers\EvaluacionesController;
use App\Http\Controllers\EvaluacionEntregaController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\NivelController;
use App\Http\Controllers\NotaEntregaController;
use App\Http\Controllers\PreguntaTareaController;
use App\Http\Controllers\RespuestaTareasController;
use App\Http\Middleware\AddCrossOriginHeaders;
use App\Mail\NuevoUsuarioRegistrado;
use App\Models\Boletin;
use App\Models\Cursos;
use App\Models\EdadDirigida;
use App\Models\NotaEntrega;
use Database\Seeders\Administrador;
use Illuminate\Support\Facades\Mail;

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




Route::get('/reciboprueba', function () {
    return view('recibo');
})->middleware('noCache');

Route::get('/login', function () {
    return view('login');
})->middleware('noCache');


Route::get('/signin', function () {
    return view('CrearUsuario.registrarse');
})->middleware('noCache')->name('signin');

Route::post('/resgistrarse', [UserController::class, 'storeUsuario'])->name('registrarse');


Route::get('/home', function () {
    return view('landing');
})->middleware('noCache')->name('home');






Route::fallback(function () {
    return view('errors.404');
});

Route::get('/cuestionario', [CuestionarioController::class, 'responder']);

Route::get('/quizzprueba', [MenuController::class, 'quizz']);



Route::post('/login', [UserController::class, 'authenticate'])->name('login.signin');





Route::group(['middleware' => ['auth']], function () {

    //Ver perfil del usuario logueado

    Route::get('/Miperfil', [UserController::class, 'UserProfile'])->name('Miperfil');
    Route::post('/Miperfil', [UserController::class, 'updateUserAvatar'])->name('avatar');



    //Editar Usuario Logueado

    Route::get('/EditarPerfil/{id}', [UserController::class, 'EditProfileIndex'])->name('EditarperfilIndex');
    Route::post('/EditarPerfil/{id}', [UserController::class, 'UserProfileEdit'])->name('EditarperfilPost');

    //Rutas Sesion
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/Inicio', [MenuController::class, 'index'])->name('Inicio');

    Route::group(['middleware' => ['role:Administrador']], function () {

        //Pagos
        Route::get('/CrearPagos', [AportesController::class, 'indexAdmin'])->name('registrarpagoadmin');
        Route::post('/CrearPagos', [AportesController::class, 'storeadmin'])->name('registrarpagopost');
        Route::get('/VistaPrevia/{id}', [AportesController::class, 'vistaPrevia'])->name('vistaprevia');


        //EditarUsuarios
        Route::get('/EditarUsuario/{id}', [AdministradorController::class, 'EditUserIndex']);
        Route::post('/EditarUsuario/{id}', [AdministradorController::class, 'EditUser'])->name('EditarperfilUser');
        Route::get('/RestaurarUsuario/{id}', [UserController::class, 'restaurarUsuario'])->name('restaurarUsuario');

        //Administrador/Docentes Rutas
        Route::get('/ListaDocente', [MenuController::class, 'ListaDocentes'])->name('ListaDocentes');
        Route::get('/ListaDocentesEliminados', [MenuController::class, 'ListaDocentesEliminados'])->name('DocentesEliminados');
        Route::get('/CrearDocente', [MenuController::class, 'storeDIndex'])->name('CrearDocente');
        Route::post('/CrearDocente', [AdministradorController::class, 'storeDocente'])->name('CrearDocentePost');
        Route::get('/deleteUser/{id}', [UserController::class, 'eliminarUsuario'])->name('eliminarUser');
        //Administrador/Cursos
        Route::get('/ListadeCursos', [MenuController::class, 'ListaDeCursos'])->name('ListadeCursos');
        Route::get('/ListaCursosCerrados', [MenuController::class, 'ListaDeCursosEliminados'])->name('ListadeCursosEliminados');
        Route::get('/CrearCursos', [MenuController::class, 'storeCIndex'])->name('CrearCurso');
        Route::post('/CrearCursos', [AdministradorController::class, 'storeCurso'])->name('CrearCursoPost');

        Route::get('/EliminarCurso/{id}', [CursosController::class, 'eliminarCurso'])->name('quitarCurso');
        Route::get('/RetaurarCurso/{id}', [CursosController::class, 'restaurarCurso'])->name('restaurarCurso');

        //Route::post('/CrearCursos', [CursosController::class, 'store'])->name('storeCursos');
        //Administrador/Estudiantes
        Route::get('/ListaEstudiante', [MenuController::class, 'ListaEstudiantes'])->name('ListaEstudiantes');
        Route::get('/ListaEstudianteEliminados', [MenuController::class, 'ListaEstudiantesEliminados'])->name('ListaEstudiantesEliminados');
        Route::get('/CrearEstudiante', [MenuController::class, 'storeEIndex'])->name('CrearEstudiante');
        Route::post('/CrearEstudiante', [AdministradorController::class, 'storeEstudiante'])->name('CrearEstudiantePost');
        Route::get('/CrearEstudianteMenor', [MenuController::class, 'storeETIndex'])->name('CrearEstudianteMenor');
        Route::post('/CrearEstudianteMenor', [AdministradorController::class, 'storeEstudianteMenor'])->name('CrearEstudianteMenorPost');

        Route::get('/ListaAportes', [MenuController::class, 'ListaAportes'])->name('aportesLista');


        Route::get('/validar-certificado/{codigo}', [CertificadoController::class, 'validarCertificado']);






    });


    //DOCENTE
    Route::group(['middleware' => ['role:Docente|Administrador' ]], function () {
        Route::get('/NuevoNivel', [NivelController::class, 'index'])->name('crearNivel');
        Route::post('/NuevoNivel', [NivelController::class, 'store'])->name('guardarNivel');
        Route::get('/NuevaEdadRecomendada', [EdadDirigidaController::class, 'index'])->name('crearEdad');
        Route::post('/NuevaEdadRecomendada', [EdadDirigidaController::class, 'store'])->name('guardarRangodeEdad');
        Route::get('/sumario',  [MenuController::class, 'analytics'])->name('sumario');
        Route::prefix('horarios')->group(function () {
            Route::post('/store', [HorarioController::class, 'store'])->name('horarios.store');
            Route::post('/horarios/update', [HorarioController::class, 'update'])->name('horarios.update');
            Route::delete('/horarios/{id}', [HorarioController::class, 'delete'])->name('horarios.delete');
            Route::post('/horarios/{id}/restore', [HorarioController::class, 'restore'])->name('horarios.restore');
        });




        //EditarCursos
        Route::get('/EditarCurso/{id}', [CursosController::class, 'EditCIndex'])->name('editarCurso');
        Route::post('/EditarCurso/{id}', [CursosController::class, 'EditC'])->name('editarCursoPost');

        //  Route::get('/Cursos/editar/{id}', [CursosController::class, 'index']);
        //Foros
        Route::get('CrearForo/cursoid={id}', [ForoController::class, 'Crearforo'])->name('CrearForo');
        Route::post('CrearForo/cursoid={id}', [ForoController::class, 'store'])->name('CrearForoPost');
        Route::get('EditarForo/{id}', [ForoController::class, 'EditarForoIndex'])->name('EditarForo');
        Route::post('EditarForo/{id}', [ForoController::class, 'update'])->name('EditarForoPost');
        Route::get('QuitarForo/{id}', [ForoController::class, 'delete'])->name('quitarForo');
        Route::get('ForosEliminados/{id}', [ForoController::class, 'indexE'])->name('forosE');
        Route::get('RestaurarForo/{id}', [ForoController::class, 'restore'])->name('restaurar');


        //Tareas
        Route::get('crearPregunta/{id}', [CuestionarioController::class, 'crearPreguntaIndex'])->name('crearPregunta');
        Route::post('crearPregunta/{id}', [PreguntaTareaController::class, 'store'])->name('crearPreguntaPost');
        Route::get('editarPregunta/{id}', [CuestionarioController::class, 'editarPreguntaIndexT'])->name('editarPreguntaT');
        Route::post('editarPregunta/{id}', [CuestionarioController::class, 'editarPreguntaPost'])->name('editarPreguntaTPost');
        Route::get('eliminarPreguntaT/{id}', [PreguntaTareaController::class, 'delete'])->name('deletePreguntaT');

        Route::get('respuestas/pregunta{id}', [CuestionarioController::class, 'respuestas'])->name('respuestas');
        Route::post('respuestas/pregunta{id}', [RespuestaTareasController::class, 'crearRespuesta'])->name('crearRespuesta');
        Route::put('/actualizar/{id}', [RespuestaTareasController::class, 'actualizarRespuesta'])->name('actualizar.respuesta');
        Route::delete('/eliminar/{id}', [RespuestaTareasController::class, 'eliminarRespuesta'])->name('eliminar.respuesta');
        Route::post('/restaurar/{id}', [RespuestaTareasController::class, 'restaurarRespuesta'])->name('confirmar.respuesta');
        Route::get('CrearTarea/cursoid={id}', [TareasController::class, 'index'])->name('CrearTareas');
        Route::get('cuestionario/{id}', [CuestionarioController::class, 'cuestionarioTIndex'])->name('cuestionario');



        Route::post('CrearTarea/cursoid={id}', [TareasController::class, 'store'])->name('CrearTareasPost');
        Route::get('EditarTarea/{id}', [TareasController::class, 'edit'])->name('editarTarea');
        Route::post('EditarTarea/{id}', [TareasController::class, 'update'])->name('editarTareaPost');
        Route::get('QuitarTarea/{id}', [TareasController::class, 'delete'])->name('quitarTarea');
        Route::get('TareasEliminadas/{id}', [TareasController::class, 'indexTE'])->name('tareasEliminadas');
        Route::get('restaurarTarea/{id}', [TareasController::class, 'restaurarTarea'])->name('restaurarTarea');

        //Evaluaciones


        Route::get('CrearEvaluacion/cursoid={id}', [EvaluacionesController::class, 'index'])->name('CrearEvaluacion');
        Route::post('CrearEvaluacion/cursoid={id}', [EvaluacionesController::class, 'store'])->name('CrearEvaluacionPost');
        Route::get('EditarEvaluacion/{id}', [EvaluacionesController::class, 'edit'])->name('editarEvaluacion');
        Route::post('EditarEvaluacion/{id}', [EvaluacionesController::class, 'update'])->name('editarEvaluacionPost');
        Route::get('QuitarEvaluacion/{id}', [EvaluacionesController::class, 'delete'])->name('quitarEvaluacion');
        Route::get('ListaEvaluacionesEliminadas/{id}', [EvaluacionesController::class, 'indexEE'])->name('evaluacionesEliminadas');
        Route::get('restaurarEvaluacion/{id}', [EvaluacionesController::class, 'restaurarEvaluacion'])->name('restaurarEvaluacion');



        //Recursos
        Route::get('CrearRecurso/cursoid={id}', [RecursosController::class, 'index'])->name('CrearRecursos');
        Route::post('CrearRecurso/cursoid={id}', [RecursosController::class, 'store'])->name('CrearRecursosPost');
        Route::get('ModificarRecurso/cursoid={id}', [RecursosController::class, 'edit'])->name('editarRecursos');
        Route::post('ModificarRecurso/cursoid={id}', [RecursosController::class, 'update'])->name('editarRecursosPost');
        Route::get('QuitarRecurso/{id}', [RecursosController::class, 'delete'])->name('quitarRecurso');
        Route::get('RecursosEliminados/cursoid={id}', [RecursosController::class, 'indexE'])->name('ListaRecursosEliminados');

        Route::get('RestaurarRecurso/{id}', [RecursosController::class, 'restore'])->name('RestaurarRecurso');



        //AsignarCursos
        Route::get('/AsignarCursos', [InscritosController::class, 'index'])->name('AsignarCurso');
        Route::post('/AsignarCursos', [InscritosController::class, 'store'])->name('inscribir');
        //QuitarInscripcion
        Route::get('/QuitarInscripcion/{id}', [InscritosController::class, 'delete'])->name('quitar');
        Route::get('/RestaurarInscripcion/{id}', [InscritosController::class, 'restaurarInscrito'])->name('restaurarIncripcion');
        //ListaDeInscritos
        Route::get('listaRestirados/cursoid={id}', [CursosController::class, 'listaRetirados'])->name('listaretirados');
        Route::get('VerEntregadeTareas/tarea={id}', [TareasController::class, 'listadeEntregas'])->name('listaEntregas');
        Route::post('VerEntregadeTareas/tarea={id}', [TareasController::class, 'listadeEntregasCalificar'])->name('calificarT');

        Route::get('VerEntregadeEvaluaciones/evaluacion={id}', [EvaluacionesController::class, 'listadeEntregas'])->name('listaEntregasE');
        Route::post('VerEntregadeEvaluaciones/evaluacion={id}', [EvaluacionesController::class, 'listadeEntregasCalificarE'])->name('calificarE');



        //ASISTENCIA
        Route::get('listaAsistencia/cursoid={id}', [AsistenciaController::class, 'index'])->name('asistencias');
        Route::get('DarAsistencia/cursoid={id}', [AsistenciaController::class, 'index2'])->name('darasistencias');
        Route::post('DarAsistencia/cursoid={id}', [AsistenciaController::class, 'store2'])->name('darasistenciasPostIndividual');
        Route::post('listaAsistencia/cursoid={id}', [AsistenciaController::class, 'store'])->name('darasistenciasPostMultiple');
        Route::post('HistorialAsistencia/cursoid={id}', [AsistenciaController::class, 'edit'])->name('historialAsistenciasPost');

        //REPORTES
        Route::get('ReportesAsistencia/{id}', [CursosController::class, 'ReporteAsistencia'])->name('repA');
        Route::get('Reportes/{id}', [CursosController::class, 'ReporteFinal'])->name('repF');

        //BOLETIN
        Route::get('/boletinDeCalificaciones/{id}', [BoletinController::class , 'boletin'])->name('boletin');
        Route::post('/boletinDeCalificaciones/{id}', [BoletinController::class , 'guardar_boletin'])->name('boletinPost');

        //Lista
        Route::get('/listaGeneral/{id}', [CursosController::class , 'imprimir'])->name('lista');
        //REPORTE GENERAL
        Route::get('/reportegeneralCurso/{id}', [CursosController::class , 'ReporteFinalCurso'])->name('rfc');


        Route::post('/enviar-boletin/{id}', [BoletinController::class, 'enviarBoletin'])->name('enviarBoletinPost');
        Route::post('/enviar-boletin/{id}', [BoletinController::class, 'enviarBoletin'])->name('enviarBoletinPost');

        //CERTIFICADOS
        Route::get('certificados/generar/{id}/', [CertificadoController::class, 'generarCertificado'])->name('certificados.generar');
        Route::get('completado/{curso_id}/{estudiante_id}', [InscritosController::class, 'completado'])->name('completado');



    });
    //ENDDOCENTE

    //ESTUDIANTE
    Route::group(['middleware' => ['role:Estudiante|Docente|Administrador']], function () {
        // Route::get('/descargarRecurso/{nombreArchivo}', [RecursosController::class, 'descargar'])->name('descargar');
        //Calendario
        Route::get('listaParticipantes/cursoid={id}', [CursosController::class, 'listaCurso'])->name('listacurso');

        Route::get('/Notificaciones', [UserController::class, 'notificaciones'])->name('notificaciones');
        Route::get('/user/{id}', [UserController::class, 'Profile'])->name('perfil');

        Route::get('/pago/{id}', [AportesController::class, 'vistaPrevia'])->name('factura');


        Route::get('/Calendario', [MenuController::class, 'calendario'])->middleware('noCache')->name('calendario');
        //PAGOS
        Route::get('/ListadePagos', [AportesController::class, 'index'])->name('pagos');
        Route::get('/RealizarPagos', [AportesController::class, 'indexStore'])->name('registrarpago');
        Route::post('/RealizarPagos', [AportesController::class, 'store'])->name('registrarpagoPost');

        //CURSO
        Route::get('/Cursos/id/{id}', [CursosController::class, 'index'])->name('Curso');
        //FORO
        Route::get('/foro/id={id}', [ForoController::class, 'index'])->name('foro');
        Route::post('/foro/id={id}', [ForoController::class, 'storeMensaje'])->name('mensajePost');
        //RECURSOS
        Route::get('VerRecursos/cursoid={id}', [RecursosController::class, 'showRecurso'])->name('VerRecursos');
        //TAREA
        Route::get('VerTarea/{id}', [TareasController::class, 'show'])->name('VerTarea');
        Route::post('VerTarea/{id}', [TareasEntregaController::class , 'store'])->name('subirTarea');
        Route::get('QuitarEntrega/{id}', [TareasEntregaController::class , 'delete'])->name('quitarEntrega');
        //Evaluaciones
        Route::get('VerEvaluacion/{id}', [EvaluacionesController::class, 'show'])->name('VerEvaluacion');
        Route::post('VerEvaluacion/{id}', [EvaluacionEntregaController::class , 'store'])->name('subirEvaluacion');
        Route::get('QuitarEntrega/{id}', [EvaluacionEntregaController::class , 'delete'])->name('quitarEntrega');

        Route::get('/descargar-archivo/{nombreArchivo}', [CursosController::class , 'descargar'])->name('descargas');

        Route::get('/verBoletin/{id}', [BoletinController::class , 'boletinEstudiantes'])->name('verBoletin');
        Route::get('/verCalificacionFinal/{id}', [BoletinController::class , 'boletinEstudiantes2'])->name('verBoletin2');

        Route::get('/validar-certificado/{codigo}', [CertificadoController::class, 'validarCertificado']);


        Route::get('/ResolverCuestionario/{id}', [CuestionarioController::class , 'cuestionarioTSolve'])->name('resolvercuestionario');


        //ENDESTUDIANTE
        Route::post('/guardar-resultados', [NotaEntregaController::class , 'CuestionarioResultado'])->name('guardar.resultados');

        //CAMBIARcONTRASEÑA
        Route::get('CambiarContrasena/{id}', [UserController::class, 'EditPasswordIndex'])->name('CambiarContrasena');
        Route::post('CambiarContrasena/{id}', [UserController::class, 'CambiarContrasena'])->name('ambiarContrasenaPost');

        Route::get('HistorialAsistencia/cursoid={id}', [AsistenciaController::class, 'show'])->name('historialAsistencias');

    });
        Route::get('certificado/qr/{codigo}', [CertificadoController::class, 'descargarQR'])->name('descargar.qr');


});
