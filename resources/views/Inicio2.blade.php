
@section('titulo')

    Área Personal
@endsection
@section('nav')
    @if (auth()->user()->hasRole('Administrador'))
    <li class="dropdown col-3">
                    <a class="nav-item " href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <div class="media align-items-center">
                            <span class="avatar avatar-sm rounded-circle">
                                <img alt="Image placeholder" src="../assets/img/user.png">
                            </span>
                                <span class="mb-0 "> {{ auth()->user()->name }}
                                    {{ auth()->user()->lastname1 }}</span>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-left">
                        <div class=" dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Bienvenid@!</h6>
                        </div>
                        <a href="{{ route('Miperfil') }}" class="dropdown-item">
                            <i class="ni ni-single-02"></i>
                            <span>Mi perfil</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}" class="dropdown-item">
                            <i class="ni ni-user-run"></i>
                            <span>Cerrar Sesion</span>
                        </a>
                    </div>
                </li>

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

                <!-- Divider -->
                <hr class="my-3">
                <!-- Heading -->
                <h6 class="navbar-heading text-muted">Nuestros Espacios</h6>
                <!-- Navigation -->
                <ul class="navbar-nav mb-md-3">
                    <li class="nav-item">
                        <a class="nav-link"
                            href="https://www.facebook.com/profile.php?id=100063510101095&mibextid=ZbWKwL">
                            <i class="ni ni-collection"></i> Facebook
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://instagram.com/fundeducarparalavida?igshid=MzRlODBiNWFlZA==">
                            <i class="ni ni-camera-compact"></i> Instagram
                        </a>
                    </li>
                    {{-- <li class="nav-item">
            <a class="nav-link" href="">
              <i class="ni ni-"></i> Twitter
            </a>
          </li> --}}
                    <li class="nav-item">
                        <a class="nav-link" href="https://www.tiktok.com/@educarparalavida?_t=8fbFcMbWOGo&_r=1">
                            <i class="ni ni-button-play"></i> Tiktok
                        </a>
                    </li>
                </ul>
    @endif


@endsection
<!-- Navigation -->




@section('content')
@if (auth()->user()->hasRole('Administrador'))
    <div class="col-xl-12">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <h3 class="mb-0">Cursos Creados</h3>
                <div class="col text-right">
                    <a href="{{ route('CrearCurso') }}" class="btn btn-sm btn-success">Crear Curso</a>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <!-- Projects table -->
        <table class="table align-items-center table-responsive">
            <thead class="thead-light">
                <tr>
                    <th>Nº</th>
                    <th>Nombre Curso</th>
                    <th>Nivel</th>
                    <th>Docente</th>
                    <th>Edad Dirigida</th>
                    <th>Fecha Inicialización</th>
                    <th>Fecha Finalización</th>
                    <th>Formato</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cursos as $cursos)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $cursos->nombreCurso }}</td>
                        <td>{{ $cursos->nivel ? $cursos->nivel->nombre : 'N/A' }}</td>
                        <td>{{ $cursos->docente->name }} {{ $cursos->docente->lastname1 }} {{ $cursos->docente->lastname2 }}</td>
                        <td title="{{ $cursos->edad_dirigida ? $cursos->edad_dirigida->edad1 : 'N/A' }} - {{ $cursos->edad_dirigida ? $cursos->edad_dirigida->edad2 : 'N/A' }}">
                            {{ $cursos->edad_dirigida ? $cursos->edad_dirigida->nombre : 'N/A' }}</td>
                        <td>{{ $cursos->fecha_ini ? $cursos->fecha_ini : 'N/A' }}</td>
                        <td>{{ $cursos->fecha_fin ? $cursos->fecha_fin : 'N/A' }}</td>
                        <td>{{ $cursos->formato ? $cursos->formato : 'N/A' }}</td>
                        <td><a href="/EditarCurso/{{ $cursos->id }}">EDITAR</a></td>
                        <td><a href="/EliminarCurso/{{ $cursos->id }}">BORRAR</a></td>
                        <td><a href="Cursos/id/{{ $cursos->id }}">VER</a></td>
                    </tr>
                @empty
                    <td>
                        <h4>NO HAY CURSOS REGISTRADOS</h4>
                    </td>
                @endforelse
            </tbody>
        </table>
    </div>
@endif

@if (auth()->user()->hasRole('Docente') || auth()->user()->hasRole('Estudiante'))
    <div class="col-xl-12">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <h3 class="mb-0">Mis Cursos</h3>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row">
            @forelse ($cursos as $curso)
                <div class="col-md-4 mb-4">
                    <div class="card card-curso" style="background-color: #39a6cb;">
                        <h3>{{ $curso->nombreCurso }}</h3>
                        <p>{{ $curso->descripcionC }}</p>
                        <a href="Cursos/id/{{ $curso->id }}" class="btn btn-light">IR A CURSO</a>
                    </div>
                </div>
            @empty
                <div class="col">
                    <div class="alert alert-warning">
                        <p>NO HAY CURSOS REGISTRADOS</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    <style>
        /* Estilo para las tarjetas de cursos */
        .card-curso {
            background-color: #39a6cb;
            border: none;
            border-radius: 0;
            padding: 20px;
            color: #fff; /* Color del texto en las tarjetas */
        }
    </style>
@endif

@endsection




@include('layout')
