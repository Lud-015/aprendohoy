@section('titulo')
    Área Personal
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
                    <i class="ni ni-key-25 text-info"></i> Asignación de Cursos
                </a>
            </li>

        </ul>
    @endif


@endsection
<!-- Navigation -->



@section('content')
    <div class="col-xl-12">
        <a href="javascript:history.back()" class="btn btn-primary">
            &#9668; Volver
        </a>

        <div class="card-header border-0">
            <div class="row align-items-center">
                @if (auth()->user()->hasRole('Administrador'))
                    <h3 class="mb-0">Cursos Creados</h3>
                @endif

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
                            <th>Fecha Incialización</th>
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
                                <td>{{ $cursos->docente->name }} {{ $cursos->docente->lastname1 }}
                                    {{ $cursos->docente->lastname2 }}</td>
                                <td
                                    title="{{ $cursos->edad_dirigida ? $cursos->edad_dirigida->edad1 : 'N/A' }} - {{ $cursos->edad_dirigida ? $cursos->edad_dirigida->edad2 : 'N/A' }}">
                                    {{ $cursos->edad_dirigida ? $cursos->edad_dirigida->nombre : 'N/A' }}</td>
                                <td>{{ $cursos->fecha_ini ? $cursos->fecha_ini : 'N/A' }}</td>
                                <td>{{ $cursos->fecha_fin ? $cursos->fecha_fin : 'N/A' }}</td>
                                <td>{{ $cursos->formato ? $cursos->formato : 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('editarCurso', [$cursos->id]) }}">
                                        <img src="{{ asset('assets/icons/editar.png') }}" alt="Editar Icon"
                                            style="width: 16px; height: 16px;">
                                        EDITAR
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('restaurarCurso', [$cursos->id]) }}"
                                        onclick="mostrarAdvertencia(event)"">
                                        <img src="{{ asset('assets/icons/borrar.png') }}" alt="Borrar Icon"
                                            style="width: 16px; height: 16px;">
                                        RESTAURAR
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('Curso', [$cursos->id]) }}">
                                        <img src="{{ asset('assets/icons/ojo.png') }}" alt="Ver Icon"
                                            style="width: 16px; height: 16px;">
                                        VER
                                    </a>
                                </td>



                            </tr>

                        @empty
                            <td>
                                <h4>NO HAY CURSOS REGISTRADOS</h4>
                            </td>
                        @endforelse





                    </tbody>
                </table>
            @endif


            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


            <script>
                function mostrarAdvertencia(event) {
                    event.preventDefault();

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: 'Esta acción restaurara este curso. ¿Estás seguro de que deseas continuar?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, continuar',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirige al usuario al enlace original
                            window.location.href = event.target.getAttribute('href');
                        }
                    });
                }
            </script>








        </div>
    </div>


    @if (auth()->user()->hasRole('Estudiante'))
        @forelse ($inscritos as $inscritos)
            @if (auth()->user()->id == $inscritos->estudiante_id)
                <div class="curso-card">
                    <div class="curso-icon">{{ $inscritos->cursos->nombreCurso }}</div>
                    <div class="curso-nombre">{{ $inscritos->cursos->descripcionC }}</div>
                    <a href="{{ route('Curso', $inscritos->cursos_id) }}" class="curso-button">IR A CURSO</a>
                </div>
            @else
            @endif
        @empty
            <h1>NO TIENES CURSOS ASIGNADOS</h1>
        @endforelse
    @endif

    @if (auth()->user()->hasRole('Docente'))
        @forelse ($cursos as $cursos)
            @if (auth()->user()->id == $cursos->docente_id)
                <div class="curso-card">
                    <div class="curso-icon">{{ $cursos->nombreCurso }}</div>
                    <div class="curso-nombre">{{ $cursos->descripcionC }}</div>
                    <a href="{{ route('Curso', $cursos->id) }}" class="curso-button">IR A CURSO</a>
                </div>
            @else
            @endif
        @empty
            <div class="card pb-3 pt-3 col-xl-12">
                <h4>NO TIENES CURSOS ASIGNADOS</h4>
            </div>
        @endforelse
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


@endsection


@if (auth()->user()->hasRole('Docente') || auth()->user()->hasRole('Estudiante'))
    @include('FundacionPlantillaUsu.index')
@endif



@if (auth()->user()->hasRole('Administrador'))
    @include('layout')
@endif
