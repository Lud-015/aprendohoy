@section('titulo')
    Editar Curso
@endsection


@section('nav')
    @if (auth()->user()->hasRole('Administrador'))
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Miperfil') }}">
                    <i class="ni ni-circle-08 text-green"></i> Mi perfil
                </a>
            </li>
            <li class="nav-item   ">
                <a class="nav-link   " href="{{ route('Inicio') }}">
                    <i class="ni ni-tv-2 text-primary"></i> Inicio
                </a>
            </li>
            <li class="nav-item   ">
                <a class="nav-link  " href="{{ route('ListadeCursos') }}">
                    <i class="ni ni-book-bookmark text-blue"></i> Lista de Cursos
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
                <a class="nav-link " href="{{ route('aportesLista') }}">
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
    <div class="col-xl-12">
        <a href="javascript:history.back()" class="btn btn-sm btn-primary">
            &#9668; Volver
        </a>


        <br>
        <br>
        <div class="border p-3 mb-3 col-xl-12">
            <form class="form ml-3 col-10" action="{{ route('editarCursoPost', $cursos->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="nombre">Nombre Curso</label>
                    <input type="text" value="{{ $cursos->nombreCurso }}" name="nombre"
                        class="form-control custom-input">
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción Curso</label>
                    <input type="text" value="{{ $cursos->descripcionC }}" name="descripcion"
                        class="form-control custom-input">
                </div>

                <div style="display: flex; align-items: center;" class="mb-4">

                    <div class="mr-8">

                        <label @if (auth()->user()->hasRole('Docente')) disable hidden @endif for="fecha_ini">Fecha Inicio</label>
                        @if ($cursos->tipo == 'congreso')
                        <input @if (auth()->user()->hasRole('Docente')) disable hidden @endif type="datetime-local"
                        value="{{ $cursos->fecha_ini }}" name="fecha_ini" class="form-control w-auto">
                        @else
                        <input @if (auth()->user()->hasRole('Docente')) disable hidden @endif type="date"
                        value="{{ $cursos->fecha_ini }}" name="fecha_ini" class="form-control w-auto">
                        @endif

                    </div>

                    <div class="ml-3">
                        <label for="fecha_fin" @if (auth()->user()->hasRole('Docente')) disable hidden @endif>Fecha Fin</label>
                        @if ($cursos->tipo == 'congreso')
                        <input type="datetime-local" value="{{ $cursos->fecha_fin }}" name="fecha_fin" class="form-control w-auto"
                            @if (auth()->user()->hasRole('Docente')) disable hidden @endif>
                        @else
                        <input type="date" value="{{ $cursos->fecha_fin }}" name="fecha_fin" class="form-control w-auto"
                        @if (auth()->user()->hasRole('Docente')) disable hidden @endif>
                        @endif



                    </div>
                </div>
                <div style="display: flex; align-items: center;" class="mb-4">

                    <div class="mr-3">
                        <label for="fecha_fin">Nota Aprobación(Por defecto 51.)</label>
                        <input type="number" value="{{ $cursos->notaAprobacion ?? '' }}" name="nota"
                            class="form-control custom-input">
                    </div>
                    @if (auth()->user()->hasRole('Docente'))
                        <div class="ml-3">
                            <label for="fecha_fin">Tabla de Contenidos</label>
                            <br>
                            <input type="file" value="{{ $cursos->archivoContenidodelCurso ?? '' }}" name="archivo"
                                class="form-control custom-input">

                        </div>

                        @if ($cursos->archivoContenidodelCurso == '')
                            <div class="">

                                <span>No se ha cargado ningún archivo todavía</span>
                            </div>
                        @else
                            <div>
                                Archivo actual: <br>
                                <embed src="{{ asset('storage/' . $cursos->archivoContenidodelCurso) }}"
                                    type="application/pdf" width="100%" height="250px" />
                            </div>
                        @endif
                    @endif

                </div>


                <div style="display: flex; align-items: center;" class="mb-4">

                    <div class="mr-8">
                        <label for="formato">Formato</label>
                        <select name="formato" id="formato" class="form-control w-auto">
                            <option value="Presencial" {{ $cursos->formato === 'Presencial' ? 'selected' : '' }}>
                                Presencial</option>
                            <option value="Virtual" {{ $cursos->formato === 'Virtual' ? 'selected' : '' }}>Virtual
                            </option>
                            <option value="Híbrido" {{ $cursos->formato === 'Híbrido' ? 'selected' : '' }}>Híbrido
                            </option>
                        </select>
                    </div>
                    <div class="mr-8">
                        <label for="tipo">Tipo</label>
                        <select name="tipo" id="formato" class="form-control w-auto">
                            <option value="curso" {{ $cursos->tipo === 'curso' ? 'selected' : '' }}>Curso</option>
                            <option value="congreso" {{ $cursos->tipo === 'congreso' ? 'selected' : '' }}>Congreso
                            </option>
                        </select>
                    </div>

                    @if (auth()->user()->hasRole('Docente'))
                        <input type="text" value="{{ auth()->user()->id }}" name="docente_id" hidden readonly>
                    @endif

                    @if (auth()->user()->hasRole('Administrador'))
                        <div class="ml-3">
                            <label for="docente_id">Docente</label>
                            <select name="docente_id" id="" class="form-control w-auto">
                                @foreach ($docente as $docente)
                                    <option @selected($cursos->docente_id == $docente->id) @class([
                                        'bg-purple-600 text-white' => $cursos->docente_id == $docente->id,
                                    ])
                                        value="{{ $docente->id }}">{{ $docente->name }} {{ $docente->lastname1 }}
                                        {{ $docente->lastname2 }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>

                <div style="display: flex; align-items: center;" class="mb-4">

                    <div class="mr-8">
                        <label for="edad_id">Edad Dirigida</label>
                        <input name="edad_id" value="{{ $cursos->edad_dirigida }}" class="form-control w-auto">
                        </input>
                    </div>

                    <div class="ml-3">
                        <label for="nivel_id">Niveles</label>
                        <input name="nivel_id" value="{{ $cursos->nivel }}" class="form-control w-auto">
                        </input>
                    </div>
                </div>

        </div>

        <br>
        <input class="btn btn btn-success" type="submit" value="Guardar Cambios">
        <br>
        <br>



        </form>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>
@endsection


@include('layout')
