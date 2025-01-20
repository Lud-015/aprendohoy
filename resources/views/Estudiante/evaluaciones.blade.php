@section('titulo')
    Evaluacion {{ $evaluaciones->titulo_evaluacion }}
@endsection

@section('nav')
    @if (auth()->user()->hasRole('Administrador'))
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Miperfil') }}">
                    <i class="ni ni-circle-08 text-green"></i> Mi perfil
                </a>
            </li>
            <li class="nav-item  active ">
                <a class="nav-link  active " href="{{ route('Inicio') }}">
                    <i class="ni ni-tv-2 text-primary"></i> Mis Cursos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{ route('ListaDocentes') }}">
                    <i class="ni ni-single-02 text-blue"></i> Lista de Docentes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{ route('ListaEstudiantes') }}">
                    <i class="ni ni-single-02 text-orange"></i> Lista de Estudiantes
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link " href="{{ route('pagos') }}">
                    <i class="ni ni-bullet-list-67 text-red"></i> Aportes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('AsignarCurso') }}">
                    <i class="ni ni-key-25 text-info"></i> Asignar Cursos
                </a>
            </li>

        </ul>
    @endif

    @if (auth()->user()->hasRole('Docente'))
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Miperfil') }}">
                    <i class="ni ni-circle-08 text-green"></i> Mi perfil
                </a>
            </li>
            <li class="nav-item  active ">
                <a class="nav-link  active " href="{{ route('Inicio') }}">
                    <i class="ni ni-tv-2 text-primary"></i> Mis Cursos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="./examples/tables.html">
                    <i class="ni ni-bullet-list-67 text-red"></i> Aportes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('AsignarCurso') }}">
                    <i class="ni ni-key-25 text-info"></i> Asignar Cursos
                </a>
            </li>

        </ul>
    @endif

    @if (auth()->user()->hasRole('Estudiante'))
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Miperfil') }}">
                    <i class="ni ni-circle-08 text-green"></i> Mi perfil
                </a>
            </li>
            <li class="nav-item  active ">
                <a class="nav-link  active " href="{{ route('Inicio') }}">
                    <i class="ni ni-tv-2 text-primary"></i> Mis Cursos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="./examples/tables.html">
                    <i class="ni ni-bullet-list-67 text-red"></i> Mis Aportes
                </a>
            </li>


        </ul>
    @endif
@endsection



@section('content')
<div class="border p-3">
<a href="javascript:history.back()" class="btn btn-primary">
    &#9668; Volver
</a>
<br>
<br>
<div class="container">
    <h1>{{$evaluaciones->titulo_evaluacion}}</h1>


    {!! $evaluaciones->descripcionEvaluacion !!}


    @if ($evaluaciones->archivoEvaluacion != '')
    <div class="archivo-evaluacion">
        <h3>Archivo de Evaluación</h3>
        <a href="{{asset('storage/'. $evaluaciones->archivoEvaluacion)}}">VER RECURSO</a>
    </div>
    @endif

    <div class="fechas">
        <h3>Fecha de habilitación {{$evaluaciones->fecha_habilitacion}}</h3>
        <h3>Fecha de vencimiento {{$evaluaciones->fecha_vencimiento}}</h3>
    </div>

    <div class="ponderacion">
        <h3>Ponderación de la Evaluación es sobre {{$evaluaciones->puntos}}</h3>
    </div>

    @if (auth()->user()->hasRole('Estudiante'))
        @forelse ($notas as $nota)
            @if ($nota->inscripcion->estudiante_id == auth()->user()->id && $nota->evaluaciones_id == $evaluaciones->id)
                <div class="calificacion">
                    <h2 class="badge-success">CALIFICADO NOTA: {{$nota->nota}}</h2>
                    <h3>Retroalimentación</h3>
                    <h5>"{{$nota->retroalimentacion}}"</h5>
                </div>
                <br>
            @endif
        @empty
            <h2 class="badge-danger">SIN CALIFICAR</h2>
        @endforelse

        <div class="entregas-evaluaciones">
            <h2>ENTREGAS</h2>
            @forelse ($entregasEvaluaciones as $entregaEvaluacion)
                @if ($entregaEvaluacion->estudiante_id == auth()->user()->id && $entregaEvaluacion->evaluacion_id == $evaluaciones->id)
                    <br>
                    <a href="{{asset('storage/'. $entregaEvaluacion->ArchivoEntrega)}}">Ver entrega</a>
                    <br>
                    @if ($evaluaciones->cursos->fecha_fin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($evaluaciones->cursos->fecha_fin) || $evaluaciones->fecha_vencimiento && \Carbon\Carbon::now() > \Carbon\Carbon::parse($evaluaciones->fecha_vencimiento))
                    @else
                    <a href="{{route('quitarEntrega', $entregaEvaluacion->id)}}">Quitar Entrega</a>
                    @endif
                    <br>
                @endif
            @empty
                <h2 class="badge badge-info">Aún no se hicieron entregas</h2>
            @endforelse
        </div>

        <hr>
        @if ($evaluaciones->cursos->fecha_fin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($evaluaciones->cursos->fecha_fin) || $evaluaciones->fecha_vencimiento && \Carbon\Carbon::now() > \Carbon\Carbon::parse($evaluaciones->fecha_vencimiento))

        <h2>Esta Actividad ya no recibe entregas</h2>

        @else

        <form action="{{route('subirEvaluacion', $evaluaciones->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            <h3>
                <input type="text" name="evaluacion_id" value="{{$evaluaciones->id}}" hidden>
                <input type="text" name="estudiante_id" value="{{auth()->user()->id}}" hidden>
                Agregar Archivo
            </h3>

            <input type="file" name="entrega">
            <br>
            <br>
            <input type="submit" class="btn btn-dark" value="Enviar Tarea">
        </form>
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <h2 class="bg-danger alert-danger">{{$error}}</h2>
            @endforeach
        @endif
    @endif


    @if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
</div>

@endsection

@include('layout')
