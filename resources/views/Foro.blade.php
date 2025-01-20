@section('titulo')

    Foro de Discusión de {{ $foro->nombreForo }}

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
                <a class="nav-link " href="./examples/tables.html">
                    <i class="ni ni-bullet-list-67 text-red"></i> Aportes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('AsignarCurso') }}">
                    <i class="ni ni-key-25 text-info"></i> Asignación Cursos
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
                    <i class="ni ni-key-25 text-info"></i> Asignación Cursos
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
    <div class="container mt-5">
        <div class="border p-3 mb-4 bg-light rounded">
            <a href="javascript:history.back()" class="btn btn-primary mb-3">
                &#9668; Volver
            </a>

            <textarea class="form-control" cols="100" rows="5" readonly
                style="border: none; background-color: transparent;">{{ htmlspecialchars($foro->descripcionForo) }}</textarea>
        </div>

        @foreach ($forosmensajes as $mensaje)
            @if ($mensaje->foro_id == $foro->id)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $mensaje->estudiantes->name }} {{ $mensaje->estudiantes->lastname1 }}
                            {{ $mensaje->estudiantes->lastname2 }} - {{ $mensaje->tituloMensaje }}</h5>
                        <p class="card-text">{{ $mensaje->mensaje }}</p>
                    </div>
                </div>
            @endif
        @endforeach

        <div class="card mb-4">
            <div class="card-body">
                @if (
                    ($foro->cursos->fecha_fin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($foro->cursos->fecha_fin)) ||
                        ($foro->fechaFin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($foro->fechaFin)))
                    <p class="text-danger">Ya no se puede responder a este foro</p>
                @else
                    <form class="comment-form" method="POST">
                        @csrf
                        <input type="hidden" name="foro_id" value="{{ $foro->id }}">
                        <input type="hidden" name="estudiante_id" value="{{ auth()->user()->id }}">

                        <div class="mb-3">
                            <label for="tituloMensaje" class="form-label">Título de mensaje</label>
                            <input type="text" class="form-control" name="tituloMensaje"
                                placeholder="Título del Mensaje">
                        </div>

                        <div class="mb-3">
                            <label for="mensaje" class="form-label">Mensaje</label>
                            <textarea class="form-control" name="mensaje" cols="100" rows="4" placeholder="Escribe tu comentario aquí"></textarea>
                        </div>

                        <button class="btn btn-success" type="submit">Publicar Comentario</button>
                    </form>
                @endif
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@endsection

@include('layout')

{{-- </body>
</html>
 --}}
