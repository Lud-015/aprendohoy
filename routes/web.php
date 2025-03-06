<?php

use App\Http\Controllers\ActividadCompletionController;
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
use App\Http\Controllers\OpcionesController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\PreguntaTareaController;
use App\Http\Controllers\RespuestaTareasController;
use App\Http\Middleware\AddCrossOriginHeaders;
use App\Http\Controllers\TemaController;
use App\Http\Controllers\SubtemaController;
use App\Http\Controllers\TareaController;
use App\Mail\NuevoUsuarioRegistrado;
use App\Models\Boletin;
use App\Models\Cursos;
use App\Models\EdadDirigida;
use App\Models\NotaEntrega;
use Database\Seeders\Administrador;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;
use App\Models\Certificado;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\RecursoSubtemaController;
use App\Models\ActividadCompletion;
use App\Http\Controllers\BotManController;
use App\Http\Controllers\ChatbotController;


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
Route::match(['get', 'post'], '/botman', [BotManController::class, 'handle']);


Route::get('/botman/tinker', function () {
    return view('botman.tinker');
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('Inicio')->with('success', 'Tu correo ha sido verificado correctamente.');
})->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', 'Se ha enviado un nuevo enlace de verificación a tu correo.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::post('/email/resend-verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('resent', true);
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');






Route::get('/login', function () {
    return view('login');
})->middleware('noCache')->name('login');


Route::get('/registro', function () {
    return view('CrearUsuario.registrarse');
})->middleware('noCache')->name('signin');

Route::post('/resgistrarse', [UserController::class, 'storeUsuario'])->name('registrarse');


Route::get('/item/detalle/{id}', [MenuController::class, 'detalle'])->name('congreso.detalle');
Route::get('/Lista', [MenuController::class, 'lista'])->name('lista.cursos.congresos');
Route::get('/home', [MenuController::class, 'home'])->middleware('noCache')->name('home');
Route::get('/', [MenuController::class, 'home'])->middleware('noCache')->name('home');




// Ruta para mostrar el formulario de solicitud de restablecimiento
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->middleware('guest')
    ->name('password.request');

// Ruta para procesar la solicitud de enlace de restablecimiento
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->middleware('guest')
    ->name('password.email');

// Ruta para mostrar el formulario de restablecimiento de contraseña
Route::get('/password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])
    ->middleware('guest')
    ->name('password.reset');

// Ruta para procesar el restablecimiento de contraseña
Route::post('/password/reset', [ForgotPasswordController::class, 'reset'])
    ->middleware('guest')
    ->name('password.update');







// Route::get('/send-test-email', function () {
//     $content = "Este es el contenido dinámico del correo.";
//     Mail::to('ludtp350@gmail.com')->send(new TestEmail($content));

//     return "Correo enviado correctamente.";
// });


Route::fallback(function () {
    return view('errors.404');
});

Route::get('/cuestionario', [CuestionarioController::class, 'responder']);

Route::get('/quizzprueba', [MenuController::class, 'quizz']);



Route::post('/login', [UserController::class, 'authenticate'])->name('login.signin');


Route::get('/verificar-certificado/{codigo}', [CertificadoController::class, 'verificarCertificado'])->name('verificar.certificado');



Route::group(['middleware' => ['auth']], function () {



    Route::group(['middleware' => ['role:Estudiante']], function () {
        // Inscribirse a un congreso
        Route::post('/Inscribirse-Curso/{id}', [InscritosController::class, 'storeCongreso'])
            ->name('inscribirse_congreso');
    });




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

        Route::get('certificadosCongreso/generarAdm/{id}/', [CertificadoController::class, 'generarCertificadoAdmin'])->name( 'certificadosCongreso.generar.admin');

        Route::post('/cursos/{id}/activar-certificados', [CursosController::class, 'activarCertificados'])
        ->name('cursos.activarCertificados');
        // Route::get('/certificates', [cer::class, 'index'])->name('certificates.index');
        Route::post('/certificates/{id}', [CertificadoController::class, 'store'])->name('certificates.store');
        Route::post('/certificates/update/{id}', [CertificadoController::class, 'update'])->name('certificates.update');
        Route::delete('/certificates-delete/{id}', [CertificadoController::class, 'destroy'])->name('certificates.destroy');


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
        Route::put('/listaParticipantes/{inscrito}/actualizar-pago', [InscritosController::class, 'actualizarPago'])->name('curso.actualizarPago');
    });


    //DOCENTE
    Route::group(['middleware' => ['role:Docente|Administrador']], function () {
        Route::get('/sumario',  [MenuController::class, 'analytics'])->name('sumario');
        Route::get('/getEstudiantesNoInscritos/{curso_id}', [InscritosController::class, 'getEstudiantesNoInscritos']);
        //HORARIO
        Route::post('/store', [HorarioController::class, 'store'])->name('horarios.store');
        Route::post('/horarios/{id}', [HorarioController::class, 'update'])->name('horarios.update');
        Route::delete('/horarios/{id}', [HorarioController::class, 'delete'])->name('horarios.delete');
        Route::post('/horarios/{id}/restore', [HorarioController::class, 'restore'])->name('horarios.restore');

        //Cuestionarios


        Route::get('/cuestionarios/{id}', [CuestionarioController::class, 'index'])->name('cuestionarios.index');
        Route::post('/cuestionarios/{id}', [CuestionarioController::class, 'store'])->name('cuestionarios.store');

        //Preguntas

        Route::post('/Pregunta/{id}', [PreguntaController::class, 'store'])->name('pregunta.store');
        Route::post('/Pregunta/{id}/edit', [PreguntaController::class, 'edit'])->name('pregunta.update');
        Route::post('/Pregunta/{id}/delete', [PreguntaController::class, 'delete'])->name('pregunta.delete');
        Route::post('/Pregunta/{id}/restore', [PreguntaController::class, 'restore'])->name('pregunta.restore');

        //Opciones
        Route::post('/Pregunta/{id}/Respuesta/store', [OpcionesController::class, 'store'])->name('opcion.store');
        Route::post('/Pregunta/{id}/Respuesta/edit', [OpcionesController::class, 'edit'])->name('opcion.update');
        Route::post('/Pregunta/{id}/Respuesta/delete', [OpcionesController::class, 'delete'])->name('opcion.delete');
        Route::post('/Pregunta/{id}/Respuesta/restore', [OpcionesController::class, 'restore'])->name('opcion.restore');

        //Respuestas

        Route::post('/cuestionarios/{id}/respuestas', [CuestionarioController::class, 'storeRespuestas'])->name('cuestionarios.storeRespuestas');

        //EditarCursos
        Route::get('/EditarCurso/{id}', [CursosController::class, 'EditCIndex'])->name('editarCurso');
        Route::post('/EditarCurso/{id}', [CursosController::class, 'EditC'])->name('editarCursoPost');

        //Foros
        Route::get('CrearForo/cursoid={id}', [ForoController::class, 'Crearforo'])->name('CrearForo');
        Route::post('CrearForo/cursoid={id}', [ForoController::class, 'store'])->name('CrearForoPost');
        Route::get('EditarForo/{id}', [ForoController::class, 'EditarForoIndex'])->name('EditarForo');
        Route::post('EditarForo/{id}', [ForoController::class, 'update'])->name('EditarForoPost');
        Route::get('QuitarForo/{id}', [ForoController::class, 'delete'])->name('quitarForo');
        Route::get('ForosEliminados/{id}', [ForoController::class, 'indexE'])->name('forosE');
        Route::get('RestaurarForo/{id}', [ForoController::class, 'restore'])->name('restaurar');

        // Temas
        Route::get('/curso/{cursoId}/temas', [TemaController::class, 'index'])->name('temas.index');
        Route::post('/curso/{cursoId}/temas', [TemaController::class, 'store'])->name('temas.store');
        Route::post('/curso/{cursoId}/temas/update', [TemaController::class, 'update'])->name('temas.update');
        Route::post('/curso/{cursoId}/temas/delete', [TemaController::class, 'destroy'])->name('temas.delete');
        Route::post('/curso/{cursoId}/temas/restore', [TemaController::class, 'restore'])->name('temas.restore');

        // Subtemas
        Route::post('/tema/{temaId}/subtemas', [SubtemaController::class, 'store'])->name('subtemas.store');
        Route::post('/tema/{temaId}/subtemas/update', [SubtemaController::class, 'update'])->name('subtemas.update');
        Route::post('/tema/{temaId}/subtemas/delete', [SubtemaController::class, 'destroy'])->name('subtemas.destroy');
        Route::post('/tema/{temaId}/subtemas/restore', [SubtemaController::class, 'restore'])->name('subtemas.restore');


        //Tareas
        Route::get('CrearTarea/cursoid={id}', [TareasController::class, 'index'])->name('CrearTareas');
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



        //RecursosGlobal

        Route::get('CrearRecurso/cursoid={id}', [RecursosController::class, 'index'])->name('CrearRecursos');
        Route::post('CrearRecurso/cursoid={id}', [RecursosController::class, 'store'])->name('CrearRecursosPost');
        Route::get('ModificarRecurso/cursoid={id}', [RecursosController::class, 'edit'])->name('editarRecursos');
        Route::post('ModificarRecurso/cursoid={id}', [RecursosController::class, 'update'])->name('editarRecursosPost');
        Route::get('QuitarRecurso/{id}', [RecursosController::class, 'delete'])->name('quitarRecurso');
        Route::get('RecursosEliminados/cursoid={id}', [RecursosController::class, 'indexE'])->name('ListaRecursosEliminados');
        Route::get('RestaurarRecurso/{id}', [RecursosController::class, 'restore'])->name('RestaurarRecurso');

        //RecursosSubtema
        Route::post('CrearRecursoSubtema/cursoid={id}', [RecursoSubtemaController::class, 'store'])->name('CrearRecursosSubtemaPost');
        Route::post('ModificarRecursoSubtema/cursoid={id}', [RecursoSubtemaController::class, 'update'])->name('editarRecursosSubtemaPost');
        Route::get('QuitarRecursoSubtema/{id}', [RecursoSubtemaController::class, 'delete'])->name('quitarRecursoSubtema');
        Route::get('RestaurarRecursoSubtema/{id}', [RecursoSubtemaController::class, 'restore'])->name('restaurarRecursoSubtema');

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
        Route::get('/boletinDeCalificaciones/{id}', [BoletinController::class, 'boletin'])->name('boletin');
        Route::post('/boletinDeCalificaciones/{id}', [BoletinController::class, 'guardar_boletin'])->name('boletinPost');

        //Lista
        Route::get('/listaGeneral/{id}', [CursosController::class, 'imprimir'])->name('lista');
        //REPORTE GENERAL
        Route::get('/reportegeneralCurso/{id}', [CursosController::class, 'ReporteFinalCurso'])->name('rfc');


        Route::post('/enviar-boletin/{id}', [BoletinController::class, 'enviarBoletin'])->name('enviarBoletinPost');
        Route::post('/enviar-boletin/{id}', [BoletinController::class, 'enviarBoletin'])->name('enviarBoletinPost');

        //CERTIFICADOS
        Route::get('certificados/generar/{id}/', [CertificadoController::class, 'generarCertificado'])->name('certificados.generar');
        Route::get('certificadosCongreso/generar/{id}/', [CertificadoController::class, 'generarCertificadoCongreso'])->name('certificadosCongreso.generar');
        Route::get('completado/{curso_id}/{estudiante_id}', [InscritosController::class, 'completado'])->name('completado');
    });
    //ENDDOCENTE

    //ESTUDIANTE
    Route::group(['middleware' => ['role:Estudiante|Docente|Administrador']], function () {
        // Route::get('/descargarRecurso/{nombreArchivo}', [RecursosController::class, 'descargar'])->name('descargar');
        //Calendario
        Route::get('listaParticipantes/cursoid={id}', [CursosController::class, 'listaCurso'])->name('listacurso');
        // Ruta para obtener el certificado
        Route::get('/certificados/obtener/{id}', [CertificadoController::class, 'obtenerCertificado'])
            ->name('certificados.obtener');
        Route::get('/Notificaciones', [UserController::class, 'notificaciones'])->name('notificaciones');
        Route::get('/user/{id}', [UserController::class, 'Profile'])->name('perfil');

        Route::get('/pago/{$id}', [AportesController::class, 'factura'])->name('factura');


        Route::get('/Calendario', [MenuController::class, 'calendario'])->middleware('noCache')->name('calendario');
        //PAGOS
        Route::get('/ListadePagos', [AportesController::class, 'index'])->name('pagos');
        Route::get('/RealizarPagos', [AportesController::class, 'indexStore'])->name('registrarpago');
        Route::post('/RealizarPagos', [AportesController::class, 'store'])->name('registrarpagoPost');

        //CURSO
        Route::get('/Cursos/id/{id}', [CursosController::class, 'index'])->name('Curso');
        //FORO
        Route::get('/foro/id={id}', [ForoController::class, 'index'])->name('foro');
        Route::post('/foro/id={id}', [ForoController::class, 'storeMensaje'])->name('foro.mensaje.store');
        Route::post('/foro/mensaje/edit/{id}', [ForoController::class, 'editMensaje'])->name('foro.mensaje.edit');
        Route::post('/foro/mensaje/delete/{id}', [ForoController::class, 'deleteMensaje'])->name('foro.mensaje.delete');
        Route::post('/foro/respuesta/edit/{id}', [ForoController::class, 'editRespuesta'])->name('foro.respuesta.edit');
        Route::post('/foro/respuesta/delete/{id}', [ForoController::class, 'deleteRespuesta'])->name('foro.respuesta.delete');
        //RECURSOS
        Route::get('VerRecursos/cursoid={id}', [RecursosController::class, 'showRecurso'])->name('VerRecursos');
        //TAREA
        Route::get('VerTarea/{id}', [TareasController::class, 'show'])->name('VerTarea');
        Route::post('VerTarea/{id}', [TareasEntregaController::class, 'store'])->name('subirTarea');
        Route::get('QuitarEntrega/{id}', [TareasEntregaController::class, 'delete'])->name('quitarEntrega');
        //Evaluaciones
        Route::get('VerEvaluacion/{id}', [EvaluacionesController::class, 'show'])->name('VerEvaluacion');
        Route::post('VerEvaluacion/{id}', [EvaluacionEntregaController::class, 'store'])->name('subirEvaluacion');
        Route::get('QuitarEntrega/{id}', [EvaluacionEntregaController::class, 'delete'])->name('quitarEntrega');
        Route::get('/descargar-archivo/{nombreArchivo}', [CursosController::class, 'descargar'])->name('descargas');
        Route::get('/verBoletin/{id}', [BoletinController::class, 'boletinEstudiantes'])->name('verBoletin');
        Route::get('/verCalificacionFinal/{id}', [BoletinController::class, 'boletinEstudiantes2'])->name('verBoletin2');
        Route::get('/validar-certificado/{codigo}', [CertificadoController::class, 'validarCertificado']);
        Route::get('/ResolverCuestionario/{id}', [CuestionarioController::class, 'cuestionarioTSolve'])->name('resolvercuestionario');
        //MarcarCompleto
        Route::post('/tarea/{tarea}/completar', [ActividadCompletionController::class, 'marcarTareaCompletada'])->name('tarea.completar');
        Route::post('/cuestionario/{cuestionario}/completar', [ActividadCompletionController::class, 'marcarCuestionarioCompletado'])->name('cuestionario.completar');
        //ENDESTUDIANTE
        Route::post('/guardar-resultados', [NotaEntregaController::class, 'CuestionarioResultado'])->name('guardar.resultados');

        //CAMBIARcONTRASEÑA
        Route::get('CambiarContrasena/{id}', [UserController::class, 'EditPasswordIndex'])->name('CambiarContrasena');
        Route::post('CambiarContrasena/{id}', [UserController::class, 'CambiarContrasena'])->name('cambiarContrasenaPost');

        Route::get('HistorialAsistencia/cursoid={id}', [AsistenciaController::class, 'show'])->name('historialAsistencias');
        //CUESTIONARIO
        Route::get('/cuestionario/{id}/responder', [CuestionarioController::class, 'mostrarCuestionario'])->name('cuestionario.mostrar');
        Route::post('/cuestionario/{id}/responder', [CuestionarioController::class, 'procesarRespuestas'])->name('cuestionario.responder');
    });
    Route::get('certificado/qr/{codigo}', [CertificadoController::class, 'descargarQR'])->name('descargar.qr');
    //QR
    // Ruta para inscribirse utilizando el QR
    Route::get('/inscribirse/{id}/{token}', [InscritosController::class, 'inscribirse'])->name('inscribirse.qr');
});
