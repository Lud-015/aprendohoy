<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Aportes;
use App\Models\Categoria;
use App\Models\Certificado;
use App\Models\Horario;
use App\Models\User;
use App\Models\Cursos;
use App\Models\Evaluaciones;
use App\Models\Expositores;
use App\Models\Foro;
use App\Models\Inscritos;
use App\Models\Tareas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{


    public function detalle($id)
    {
        $curso = Cursos::with(['calificaciones.user', 'inscritos'])
            ->withAvg('calificaciones', 'puntuacion')
            ->withCount('calificaciones')
            ->findOrFail($id);

        $usuarioInscrito = $curso->inscritos->firstWhere('estudiante_id', Auth::id());






        // Verificar si el usuario ya calificó el curso
        $usuarioCalifico = false;
        $calificacionUsuario = null;

        if (Auth::check()) {
            $calificacionUsuario = $curso->calificaciones->where('user_id', Auth::id())->first();
            $usuarioCalifico = $calificacionUsuario !== null;
        }

        return view('cursosDetalle', [
            'cursos' => $curso,
            'usuarioInscrito' => $usuarioInscrito,
            'usuarioCalifico' => $usuarioCalifico,
            'calificacionUsuario' => $calificacionUsuario,
            'calificacionesRecientes' => $curso->calificaciones()
                ->with('user')
                ->latest()
                ->take(5)
                ->get()
        ]);
    }






    public function home()
    {
        $currentDate = Carbon::now(); // Fecha actual

        // Filtrar congresos cuya fecha_fin no ha pasado
        $congresos = Cursos::where('tipo', 'congreso')
            ->where('fecha_fin', '>=', $currentDate)
            ->get();

        // Filtrar cursos cuya fecha_fin no ha pasado
        $cursos = Cursos::where('tipo', 'curso')
            ->where('fecha_fin', '>=', $currentDate)
            ->get();

        return view('landing')->with('congresos', $congresos)->with('cursos', $cursos);
    }
    public function index()
    {
        // Consultas optimizadas por conteo si solo usas los totales
        $totalCursos = Cursos::whereNull('deleted_at')->count();
        $totalEstudiantes = User::role('Estudiante')->whereNull('deleted_at')->count();
        $totalDocentes = User::role('Docente')->whereNull('deleted_at')->count();
        $totalInscritos = Inscritos::whereNull('deleted_at')->count();

        // Para listas completas que podrías necesitar en tabs o tablas
        $categorias = Categoria::whereNull('deleted_at')->get();
        $certificados = Certificado::whereNull('deleted_at')->get();
        $aportes = Aportes::whereNull('deleted_at')->get();
        $foros = Foro::whereNull('deleted_at')->get();
        $actividades = Actividad::whereNull('deleted_at')->get();
        $expositores = Expositores::whereNull('deleted_at')->get();

        // Solo una vez los cursos, evita duplicación ($cursos2 no es necesario)
        $cursos = Cursos::whereNull('deleted_at')->get();
        $inscritos = Inscritos::whereNull('deleted_at')->get();
        $estudiantes = User::role('Estudiante')->whereNull('deleted_at')->get();
        $docentes = User::role('Docente')->whereNull('deleted_at')->get();

        // Logs internos (limitado para evitar mostrar todo el archivo)
        $logPath = storage_path('logs/laravel.log');
        $logs = file_exists($logPath) ? collect(explode("\n", file_get_contents($logPath)))->take(-100)->implode("\n") : 'No hay logs disponibles.';

        return view('Inicio', compact(
            'categorias', 'certificados', 'aportes', 'foros',
            'actividades', 'expositores', 'cursos', 'inscritos',
            'estudiantes', 'docentes', 'totalCursos', 'totalEstudiantes',
            'totalDocentes', 'totalInscritos', 'logs'
        ));
    }


    public function ListaDeCursos()
    {

        $cursos = Cursos::whereNull('deleted_at')->get();
        $inscritos = Inscritos::all();
        return view('ListaDeCursos')->with('cursos', $cursos)->with('inscritos', $inscritos);
    }

    public function ListaDeCursosEliminados()
    {

        $cursos = Cursos::onlyTrashed()->get();

        return view('Administrador.ListadeCursosEliminados')->with('cursos', $cursos);
    }

    public function lista(Request $request)
    {
        // 1. Validación básica de los parámetros de entrada
        $validated = $request->validate([
            'type' => 'nullable|in:curso,congreso',
            'sort' => 'nullable|in:price_asc,price_desc,date_desc,rating_desc',
            'search' => 'nullable|string|max:255',
            'formato' => 'nullable|in:Presencial,Virtual,Híbrido',
            'nivel' => 'nullable|string',
            'visibilidad' => 'nullable|in:publico,privado',
            'categoria' => 'nullable|exists:categoria,id' // Filtro por categoría
        ]);

        // 2. Crear la consulta base con todas las relaciones necesarias
        $query = Cursos::query()
            ->with([
                'docente',
                'categorias', // Relación muchos a muchos
                'calificaciones' => function($q) {
                    $q->select('curso_id', 'puntuacion'); // Solo campos necesarios para optimizar
                }
            ])
            ->withAvg('calificaciones', 'puntuacion') // Promedio de calificaciones
            ->withCount('calificaciones') // Cantidad de calificaciones
            ->withCount('inscritos'); // Cantidad de inscritos

        // 3. Filtro de visibilidad basado en rol
        $isAdmin = auth()->user() && auth()->user()->hasRole('Administrador');
        if (!$isAdmin) {
            $query->where('visibilidad', 'publico');
        } elseif ($request->filled('visibilidad')) {
            $query->where('visibilidad', $validated['visibilidad']);
        }

        // 4. Filtro de búsqueda (incluye nombre del curso, descripción y categorías)
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombreCurso', 'like', '%' . $request->search . '%')
                    ->orWhere('descripcionC', 'like', '%' . $request->search . '%')
                    ->orWhereHas('categorias', function($catQuery) use ($request) {
                        $catQuery->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // 5. Filtros simples
        if ($request->filled('type')) {
            $query->where('tipo', $request->type);
        }

        if ($request->filled('formato')) {
            $query->where('formato', $request->formato);
        }

        if ($request->filled('nivel')) {
            $query->where('nivel', $request->nivel);
        }

        // 6. Filtro por categoría (relación muchos a muchos)
        if ($request->filled('categoria')) {
            $query->whereHas('categorias', function($catQuery) use ($validated) {
                $catQuery->where('categoria.id', $validated['categoria']);
            });
        }

        // 7. Ordenamiento
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('precio', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('precio', 'desc');
                    break;
                case 'date_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'rating_desc':
                    $query->orderByDesc('calificaciones_avg_puntuacion')
                          ->orderByDesc('calificaciones_count');
                    break;
            }
        } else {
            // Ordenamiento por defecto: mejor calificados primero, luego por fecha
            $query->orderByDesc('calificaciones_avg_puntuacion')
                  ->orderBy('created_at', 'desc');
        }

        // 8. Paginación
        $cursos = $query->paginate(9)->withQueryString();

        // 9. Obtener categorías para el filtro (solo las que tienen cursos públicos)
        $categorias = Categoria::whereHas('cursos', function($q) use ($isAdmin) {
                if (!$isAdmin) {
                    $q->where('visibilidad', 'publico');
                }
            })
            ->withCount(['cursos' => function($q) use ($isAdmin) {
                if (!$isAdmin) {
                    $q->where('visibilidad', 'publico');
                }
            }])
            ->orderBy('name')
            ->get();

        // 10. Estadísticas adicionales para la vista
        $stats = [
            'total_cursos' => $cursos->total(),
            'promedio_general' => $cursos->avg('calificaciones_avg_puntuacion'),
            'categorias_disponibles' => $categorias->count()
        ];

        // 11. Retornar la vista con los datos
        return view('listacursoscongresos', [
            'cursos' => $cursos,
            'categorias' => $categorias,
            'filters' => $validated,
            'stats' => $stats
        ]);
    }




    public function ListaDocentes(Request $request)
    {
        $search = $request->input('search');

        $docentes = User::role('Docente')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%$search%")
                    ->orWhere('lastname1', 'like', "%$search%")
                    ->orWhere('lastname2', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('Celular', 'like', "%$search%");
            })
            ->paginate(10);
        return view('Administrador.ListadeDocentes')->with('docentes', $docentes);
    }
    public function ListaDocentesEliminados()
    {
        $docente = User::role('Docente')->onlyTrashed()->get();
        return view('Administrador.ListadeDocentesEliminados')->with('docente', $docente);
    }

    public function ListaAportes()
    {
        $aportes = Aportes::all();
        return view('Administrador.ListadeAportes')->with('aportes', $aportes);
    }


    public function ListaEstudiantes(Request $request)
    {
        $search = $request->input('search');

        $estudiantes = User::role('Estudiante')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%$search%")
                    ->orWhere('lastname1', 'like', "%$search%")
                    ->orWhere('lastname2', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('Celular', 'like', "%$search%");
            })
            ->paginate(10);


        return view('Administrador.ListadeEstudiantes')->with('estudiantes', $estudiantes);
    }
    public function ListaEstudiantesEliminados(Request $request)
    {
        $estudiantes = User::role('Estudiante')->onlyTrashed()->get();

        return view('Administrador.ListadeEstudiantesEliminados')->with('estudiantes', $estudiantes);
    }



    public function storeDIndex()
    {
        return view('Administrador.CrearDocente');
    }
    public function storeETIndex()
    {
        return view('Administrador.CrearEstudianteConTutor');
    }
    public function storeEIndex()
    {
        return view('Administrador.CrearEstudiante');
    }


    public function ListaCursos()
    {

        $cursos = Cursos::whereNull('deleted_at')->get();

        return view('Inicio')->with('cursos', $cursos);
    }

    public function storeCIndex()
    {

        $docente = User::role('Docente')->get();
        $horario = Horario::all();

        return view('Administrador.CrearCursos')->with('docente', $docente)->with('horario', $horario);
    }

    public function calendario()
    {
        // Obtener los cursos según el rol del usuario
        if (Auth::user()->hasRole('Docente')) {
            $cursos = Cursos::where('docente_id', Auth::user()->id)->get();
        } elseif (Auth::user()->hasRole('Estudiante')) {
            $inscripciones = Inscritos::where('estudiante_id', Auth::user()->id)->get();
            $cursos = Cursos::whereIn('id', $inscripciones->pluck('cursos_id'))->get();
        }

        // Colección para almacenar todas las actividades
        $actividades = collect();

        // Obtener actividades para cada curso
        foreach ($cursos as $curso) {
            $actividadesCurso = Actividad::with(['subtema.tema', 'tipoActividad'])
                ->whereHas('subtema.tema', function ($query) use ($curso) {
                    $query->where('curso_id', $curso->id);
                })
                ->get();

            $actividades = $actividades->merge($actividadesCurso);
        }

        return view('calendario', [
            'actividades' => $actividades,
            'cursos' => $cursos
        ]);
    }

    public function analytics()
    {
        $cursos2 = Cursos::whereNull('deleted_at')->get();

        return view('Docente.analitics')->with('cursos2', $cursos2);
    }

    public function quizz()
    {

        return view('quizzprueba');
    }
}
