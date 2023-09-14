@section('titulo')
Area Personal
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
<!-- Navigation -->



@section('content')
<div class="col-xl-12">
        <div class="card-header border-0">
            <div class="row align-items-center">
                    @if (auth()->user()->hasRole('Administrador'))
                        <h3 class="mb-0">Cursos Creados</h3>
                    @endif
                    @if (auth()->user()->hasRole('Docente') ||
                            auth()->user()->hasRole('Estudiante'))
                        <h3 class="mb-0">Mis Cursos</h3>
                    @endif
                <div class="col text-right">
                    {{-- <a href="#!" class="btn btn-sm btn-success">Ver Todos</a> --}}
                    @if (auth()->user()->hasRole('Administrador'))
                        <a href="{{ route('CrearCurso') }}" class="btn btn-sm btn-success">Crear Curso</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="table-responsive ">
            <!-- Projects table -->
            @if (auth()->user()->hasRole('Administrador'))
                <table class="table align-items-center table-responsive">
                    <thead class="thead-light">
                        <tr>
                            <th>Nº</th>
                            <th>Nombre Curso</th>
                            <th>Nivel</th>
                            <th>Docente</th>
                            <th>Edad Dirigida</th>
                            <th>Fecha Incializacion</th>
                            <th>Fecha Finalizacion</th>
                            <th>Formato</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($cursos as $cursos)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $cursos->nombreCurso }}</td>
                                <td>{{ $cursos->nivel ? $cursos->nivel->nombre : 'N/A' }}</td>
                                <td>{{ $cursos->docente->name }} {{ $cursos->docente->lastname1 }}
                                    {{ $cursos->docente->lastname2 }}</td>
                                <td
                                    title="{{ $cursos->edad_dirigida ? $cursos->edad_dirigida->edad1 : 'N/A' }} - {{ $cursos->edad_dirigida ? $cursos->edad_dirigida->edad2 : 'N/A' }}">
                                    {{ $cursos->edad_dirigida ? $cursos->edad_dirigida->nombre : 'N/A' }}</td>
                                <td>{{ $cursos->fecha_ini ? $cursos->fecha_ini : 'N/A' }}</td>
                                <td>{{ $cursos->fecha_fin ? $cursos->fecha_fin : 'N/A' }}</td>
                                <td>{{ $cursos->formato ? $cursos->formato : 'N/A' }}</td>
                                <td><a href="/EditarCurso/{{$cursos->id}}">EDITAR</a></td>
                                <td><a href="">BORRAR</a></td>
                                <td><a href="Cursos/id/{{ $cursos->id }}">VER</a></td>

                            </tr>
                        @endforeach
                        {{-- <tr>

                                          <th scope="row">
                                              Matematicas
                                          </th>
                                          <td>
                                              Juan Perez
                                          </td>
                                          <td>
                                              14
                                          </td>
                                          <td>
                                              <div class="d-flex align-items-center">
                                                  <span class="mr-2">0%</span>
                                                  <div>
                                                      <div class="progress">
                                                          <div class="progress-bar bg-gradient-danger"
                                                              role="progressbar" aria-valuenow="60" aria-valuemin="0"
                                                              aria-valuemax="100" style="width: 60%;"></div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </td>
                                      </tr> --}}
                    </tbody>
                </table>
            @endif
            @if (auth()->user()->hasRole('Docente'))
                @foreach ($cursos as $cursos)
                    @if (auth()->user()->id == $cursos->docente_id)
                        <div class="card pb-3 pt-3 col-xl-12">
                            <br>
                            <h3>{{ $cursos->nombreCurso }}</h3>
                            <br>

                            <p>{{ $cursos->descripcionC }}</p>
                            <p> <a href="Cursos/id/{{ $cursos->id }}">IR A CURSO</a> </p>
                            <div class="progress">
                                <div class="progress-bar bg-gradient-info" role="progressbar" aria-valuenow="0"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 1%;"></div>
                            </div>
                        </div>
                    @else
                        {{-- <h1>NO TIENES CURSOS ASIGNADOS</h1> --}}
                    @endif
                @endforeach


            @endif
            @if (auth()->user()->hasRole('Estudiante'))
                @foreach ($inscritos as $inscritos)
                    @if (auth()->user()->id == $inscritos->estudiante_id)
                        <div class="card pb-3 pt-3 col-xl-12">
                            <br>
                            <h3>{{ $inscritos->cursos->nombreCurso }}</h3>
                            <br>

                            <p>{{ $inscritos->cursos->descripcionC }}</p>
                            <p> <a href="Cursos/id/{{ $inscritos->cursos_id }}">IR A CURSO</a> </p>
                            <div class="progress">
                                <div class="progress-bar bg-gradient-info" role="progressbar" aria-valuenow="0"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 1%;"></div>
                            </div>
                        </div>
                    @else
                        {{-- <h1>NO TIENES CURSOS ASIGNADOS</h1> --}}
                    @endif
                @endforeach


            @endif





    </div>
</div>
@endsection

@include('layout')

