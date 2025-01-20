@section('titulo')
    Dar Asistencia
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
                <a class="nav-link " href="{{ route('aportesLista') }}">
                    <i class="ni ni-bullet-list-67 text-red"></i> Aportes
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link active" href="{{ route('AsignarCurso') }}">
                    <i class="ni ni-key-25 text-info"></i> Asignación de Cursos
                </a>
            </li>

        </ul>
    @endif

    @if (auth()->user()->hasRole('Docente'))
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Miperfil') }}">
                    <img src="{{ asset('assets/icons/user.png') }}" alt="Mi perfil Icon"
                        style="width: 16px; margin-right: 10px;">
                    Mi perfil
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link active" href="{{ route('Inicio') }}">
                    <img src="{{ asset('assets/icons/cursos.png') }}" alt "cursos" style="width: 16px; margin-right: 10px;">
                    Mis Cursos
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="{{ route('pagos') }}">
                    <img src="{{ asset('assets/icons/pago.png') }}" alt "pago" style="width: 16px; margin-right: 10px;">
                    Mis Aportes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('AsignarCurso') }}">
                    <img src="{{ asset('assets/icons/asignar.png') }}" alt="Asignar Cursos Icon"
                        style="width: 16px; margin-right: 10px;">
                    Asignación de Cursos
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
        <form method="POST" action="{{ route('darasistenciasPostIndividual', $cursos->id) }}">
            @csrf
            <div class="card-body p-3">
                <div class="row">
                    <input type="text" name="curso_id" value="{{ $cursos->id }}" hidden>
                    <div class="col-md-6 mb-md-0 mb-4">
                        <h3>Fecha</h3>
                        <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">


                            <input type="date" name="fecha" id=""
                                @if ($cursos->fecha_fin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($cursos->fecha_fin)) disabled
                        @else @endif>

                        </div>
                    </div>

                    <div class="col-md-6">
                        <h3>Estudiante</h3>
                        <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                            <select name="estudiante" id="" class="mb-0 bg-transparent border-0"
                                @if ($cursos->fecha_fin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($cursos->fecha_fin)) disabled
                            @else @endif>

                                @forelse ($inscritos as $inscritos)
                                    <option value="{{ $inscritos->id }}">
                                        {{ $inscritos->estudiantes->name . ' ' . $inscritos->estudiantes->lastname1 . ' ' . $inscritos->estudiantes->lastname2 }}
                                    </option>
                                @empty
                                    <option value="">
                                        NO HAY ESTUDIANTES REGISTRADOS
                                    </option>
                                @endforelse


                            </select>
                        </div>


                    </div>

                    <div class="col-md-6">
                        <h3>Tipo de Asistencia</h3>
                        <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                            <select name="asistencia" class="form-control"
                                @if ($cursos->fecha_fin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($cursos->fecha_fin)) disabled
                            @else @endif>
                                <option value="">Selecciona un tipo de asistencia</option>
                                <option value="Presente">Presente</option>
                                <option value="Retraso">Retraso</option>
                                <option value="Licencia">Licencia</option>
                                <option value="Falta">Falta</option>
                            </select>
                        </div>


                    </div>

                </div>
                <br><br>

                @if ($cursos->fecha_fin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($cursos->fecha_fin))
                @else
                <input class="btn btn-lg btn-success" type="submit" value="DAR ASISTENCIA">
                @endif


            </div>
        </form>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <h2 class="bg-danger alert-danger">{{ $error }}</h2>
            @endforeach
        @endif


        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif



    @endsection

    @extends('layout')
