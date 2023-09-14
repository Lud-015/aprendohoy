


@section('titulo')
{{ $cursos->nombreCurso }}
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



@section('contentup')

<div class="header bg-gradient-info pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-12 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <h5 class="card-title text-uppercase text-muted mb-0">Docente:
                                {{ $cursos->docente->name }} {{ $cursos->docente->lastname1 }}
                                {{ $cursos->docente->lastname2 }}</h5>
                            <div class="row">

                                <div class="col">
                                    <span class="h2 font-weight-bold mb-0">Presentacion de la
                                        asignatura</span>
                                    <h5 class="card-title text-uppercase text-muted mb-0">
                                        {{ $cursos->descripcionC }}
                                    </h5>

                                    <br><br>
                                    @if ($cursos->docente_id == auth()->user()->id || auth()->user()->hasRole('Administrador'))
                                        <i class="fas fa-user"></i>
                                        <a href="{{ route('listacurso', [$cursos->id]) }}"> Ver
                                            Participantes &nbsp;&nbsp;&nbsp;&nbsp;</a>
                                        <i class="fas fa-list"></i>
                                        <a href=""> Calificaciones &nbsp;&nbsp;&nbsp;&nbsp;</a>
                                        <i class="fas fa-archive"></i>
                                        <a href=""> Plan Global del la asignatura</a>
                                        &nbsp;
                                        <i class="fas fa-edit"></i>
                                        <a href=""> Editar Curso</a>
                                        &nbsp;

                                        <i class="fas fa-check"></i>
                                        <a href=""> Dar Asistencia</a>
                                    @endif

                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                        <i class="fas fa-cube"></i>
                                    </div>
                                </div>
                            </div>
                            {{-- <p class="mt-3 mb-0 text-muted text-sm">
          <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
          <span class="text-nowrap">Since last month</span>
        </p> --}}
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>

@endsection

@section('content')


@if (auth()->user()->hasRole('Docente') && $cursos->docente_id == auth()->user()->id  || auth()->user()->hasRole('Administrador'))
<div class="row mt-5">
        <div class="col-xl-12">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Foros</h3>

                        </div>
                        <div class="col text-right">
                            {{-- <a href="#!" class="btn btn-sm btn-success">Ver Todos</a> --}}
                            <a href="{{ route('CrearForo', [$cursos->id]) }}" class="btn btn-sm btn-success">Crear Foro</a>
                        </div>
                    </div>
                </div>
                @foreach ($foros as $foros)

                <div class="table-responsive">
                    <!-- Projects table -->


                    <div class="card pb-3 pt-3  col-xl-12">
                        <br>
                        <h3>{{$foros->nombreForo}}</h3>
                        <br>
                        <p>Desripcion Foro</p>
                        <p> <a href="{{route('foro', [$foros->id])}}">IR A FORO</a> </p>
                    </div>
                </div>
                @endforeach






            </div>
        </div>
</div>
<div class="col-xl-12">
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">Tareas</h3>

                </div>
                <div class="col text-right">
                    <a href="" class="btn btn-sm btn-success">Crear Tarea</a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <!-- Projects table -->


            <div class="card pb-3 pt-3  col-xl-12">
                <br>
                <h3>Evaluacion Diagnostica</h3>
                <br>

                <p>Elaborar Diagnostico</p>
                <p>Vence el: 12/09/2023</p>

                <p> <a href="Cursos/id/{{ $cursos->id }}">IR A ACTIVIDAD</a> </p>

            </div>






        </div>
    </div>
</div>
@elseif ($inscritos)
<div class="row mt-5">
    <div class="col-xl-12">
        <div class="card shadow">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Foros</h3>

                    </div>
                    <div class="col text-right">
                        {{-- <a href="#!" class="btn btn-sm btn-success">Ver Todos</a> --}}
                        <a href="{{ route('CrearForo', [$cursos->id]) }}" class="btn btn-sm btn-success">Crear Foro</a>
                    </div>
                </div>
            </div>
            @foreach ($foros as $foros)

            <div class="table-responsive">
                <!-- Projects table -->


                <div class="card pb-3 pt-3  col-xl-12">
                    <br>
                    <h3>{{$foros->nombreForo}}</h3>
                    <br>
                    <p>Desripcion Foro</p>
                    <p>{{$foros->SubtituloForo}}</p>
                    <p>Fecha de Finalizacion</p>
                    <p>{{$foros->fechaFin}}</p>
                    <p> <a href="{{route('foro', [$foros->id])}}">IR A FORO</a> </p>
                </div>
            </div>
            @endforeach






        </div>
    </div>
</div>

<div class="col-xl-12">
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">Tareas</h3>

                </div>
                <div class="col text-right">
                    <a href="" class="btn btn-sm btn-success">Crear Tarea</a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <!-- Projects table -->


            <div class="card pb-3 pt-3  col-xl-12">
                <br>
                <h3>Evaluacion Diagnostica</h3>
                <br>

                <p>Elaborar Diagnostico</p>
                <p>Vence el: 12/09/2023</p>

                <p> <a href="Cursos/id/{{ $cursos->id }}">IR A ACTIVIDAD</a> </p>

            </div>






        </div>
    </div>
</div>
@else
<div class="col-xl-12">
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <div class="col text-right">
                        <h3>USTED NO ESTA ASIGNADO A ESTA MATERIA</h3>
                        <a href="{{ route('Inicio') }}" class="btn btn-sm btn-info">Volver a Inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection

@include('CursosLayout')

