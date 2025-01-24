@section('titulo')

Lista de Paticipantes {{$cursos->nombreCurso}}

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
<div class="col-xl-12">
    <a href="{{route('Curso', ['id' => $cursos->id])}}" class="btn btn-primary">
    &#9668; Volver
    </a>
@if (auth()->user()->hasRole('Docente')|| auth()->user()->hasRole('Administrador'))

<a class="btn btn-warning" href="{{route('listaretirados', $cursos->id)}}">Lista Retirados</a>
<a class="btn btn-dark" href="{{route('lista', $cursos->id)}}">Descargar Lista</a>

@endif
<br>
<br>
<div class="">

<div class="col-lg-12 row">
    <form class="navbar-search navbar-search form-inline mr-3 d-none d-md-flex ml-lg-auto">
        <div class="input-group">
              <span class="input-group-text"><i class="fas fa-search"></i></span>
              <input class="form-control search-input" placeholder="Buscar" type="text" id="searchInput">
        </div>
    </form>
    </div>

                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Nro</th>
                            <th scope="col">Nombre y Apellidos</th>
                            <th scope="col">Celular</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($inscritos as $inscritos)
                        @if ($inscritos->cursos_id == $cursos->id)
                        <tr>

                            <td scope="row">

                                {{ $loop->iteration }}

                            </td>
                            <td scope="row">
                                {{ isset($inscritos->estudiantes) ? $inscritos->estudiantes->name : 'Estudiante Eliminado' }}
                                {{ isset($inscritos->estudiantes) ? $inscritos->estudiantes->lastname1 : '' }}
                                {{ isset($inscritos->estudiantes) ? $inscritos->estudiantes->lastname2 : '' }}
                            </td>
                            <td>
                                {{ isset($inscritos->estudiantes) ? $inscritos->estudiantes->Celular : '' }}
                            </td>
                            <td>

                                <a class="btn btn-sm btn-info" href="{{ route('perfil', [$inscritos->estudiantes->id])}}">Ver Más</a>
                            @if (auth()->user()->hasRole('Docente') || auth()->user()->hasRole('Administrador'))
                                <a class="btn btn-sm btn-danger" href="{{ route('quitar', [$inscritos->id])}}" onclick="mostrarAdvertencia(event)">Quitar incscripción</a>
                                @if ($cursos->fecha_fin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($cursos->fecha_fin))

                                <a class="btn btn-sm btn-info" href="{{ route('boletin', [$inscritos->id])}}">Ver Boletín</a>/
                                <a class="btn btn-sm btn-info" href="{{route('verBoletin2', [$inscritos->id])}}"> Ver Calificaciones Finales</a>

                                @else
                                @endif

                                <a class="btn btn-sm btn-info" href="{{ route('certificados.generar', ['id' => $inscritos->id ]) }}"> Ver Certificado</a>

                                <a class="btn btn-sm btn-success" href="{{ route('completado', ['curso_id' => $inscritos->cursos_id, 'estudiante_id' => $inscritos->id]) }}"> Completado</a>

                                @endif
                            </td>
                        </tr>
                        @endif


                        @empty
                        <tr>

                            <td>

                                <h4>NO HAY ALUMNOS INSCRITOS</h4>

                            </td>
                        </tr>




                        @endforelse


                    </tbody>
                </table>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        function mostrarAdvertencia(event) {
            event.preventDefault();

            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción retirara a este estudiante. ¿Estás seguro de que deseas continuar?, Esta opcion contrae problemas todavia y se esta revisando para que sea funcional totalmente',
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


    <!-- Agrega esto en tu archivo Blade antes de </body> -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        $(document).ready(function() {
            // Manejo del evento de entrada en el campo de búsqueda
            $('input[type="text"]').on('input', function() {
                var searchText = $(this).val().toLowerCase();

                // Filtra las filas de la tabla basándote en el valor del campo de búsqueda
                $('tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
                });
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Manejo del evento de entrada en el campo de búsqueda
            $('.search-input').on('input', function() {
                var searchText = $(this).val().toLowerCase();

                // Filtra las filas de la tabla basándote en el valor del campo de búsqueda
                $('tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
                });
            });
        });
    </script>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif



@endsection

@include('layout')
