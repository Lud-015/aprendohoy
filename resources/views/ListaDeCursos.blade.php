@section('titulo')
    Lista de cursos
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
            <li class="nav-item  active ">
                <a class="nav-link  " href="{{ route('ListadeCursos') }}">
                    <i class="ni ni-books text-primary"></i> Lista de Cursos
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
    <div class="col-xl-12 mt--3">
        <div class="card-header border-0">
            <div class="row align-items-center">
                @if (auth()->user()->hasRole('Administrador'))
                <div class="mb-4">
                    <a href="{{ route('CrearCurso') }}" class="btn btn-sm btn-success">Crear Curso</a>
                    <a href="{{ route('ListadeCursosEliminados') }}" class="btn btn-sm btn-info">Cursos Eliminados</a>
                </div>
                @endif
            </div>
            <input class="form-control search-input" placeholder="Buscar" type="text" id="searchInput">
        </div>
        <div class="table-responsive ">
            <!-- Projects table -->
            @if (auth()->user()->hasRole('Administrador'))
                <table class="table align-items-center table-responsive">
                    <thead class="thead-light">
                        <tr>
                            <th>Nº</th>
                            <th>Nombre Curso</th>
                            <th>Docente</th>
                            <th>Fecha Incialización</th>
                            <th>Fecha Finalización</th>
                            <th>Formato</th>
                            <th>Tipo</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($cursos as $cursos)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ ucfirst(strtolower($cursos->nombreCurso)) }}</td>
                                <td>{{ $cursos->docente ? $cursos->docente->name . ' ' . $cursos->docente->lastname1 . ' ' . $cursos->docente->lastname2 : 'N/A' }}
                                </td>
                                <td>{{ $cursos->fecha_ini ? $cursos->fecha_ini : 'N/A' }}</td>
                                <td>{{ $cursos->fecha_fin ? $cursos->fecha_fin : 'N/A' }}</td>
                                <td>{{ $cursos->formato ? $cursos->formato : 'N/A' }}</td>
                                <td>{{ ucfirst(strtolower($cursos->tipo)) ? $cursos->tipo : 'N/A' }}</td>
                                <td>
                                    <a class="btn btn-sm btn-warning" href="{{ route('editarCurso', $cursos->id) }}">
                                        <img src="{{ asset('assets/icons/editar.png') }}" alt="Editar Icon"
                                            style="width: 16px; height: 16px;">
                                        Editar
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-danger" href="{{ route('quitarCurso', [$cursos->id]) }}"
                                        onclick="mostrarAdvertencia(event)"">
                                        <img src="{{ asset('assets/icons/borrar.png') }}" alt="Borrar Icon"
                                            style="width: 16px; height: 16px;">
                                            Borrar
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-info" href="{{ route('Curso', [$cursos->id]) }}">
                                        <img src="{{ asset('assets/icons/ojo.png') }}" alt="Ver Icon"
                                        style="width: 16px; height: 16px;">
                                        Ver
                                    </a>
                                    <button type="button " class="btn btn-sm btn-info" data-toggle="modal" data-target="#courseModal{{ $cursos->id }}">
                                        Ver Detalles del Curso
                                    </button>

                                    <!-- Modal Structure for each course -->
                                    <div class="modal fade" id="courseModal{{ $cursos->id }}" tabindex="-1" role="dialog" aria-labelledby="courseModalLabel{{ $cursos->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="courseModalLabel{{ $cursos->id }}">Detalles del Curso</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Nombre del Curso:</strong> {{ ucfirst(strtolower($cursos->nombreCurso)) }}</p>
                                                    <p><strong>Nivel del Curso:</strong> {{ $cursos->nivel ? ucfirst(strtolower($cursos->nivel)) : 'N/A' }}</p>
                                                    <p><strong>Instructor:</strong> {{ $cursos->docente ? $cursos->docente->name . ' ' . $cursos->docente->lastname1 . ' ' . $cursos->docente->lastname2 : 'N/A' }}</p>
                                                    <p><strong>Edad Dirigida:</strong> {{ $cursos->edad_dirigida ? ucfirst(strtolower($cursos->edad_dirigida)) : 'N/A' }}</p>
                                                    <p><strong>Fecha de Inicio:</strong> {{ $cursos->fecha_ini ? $cursos->fecha_ini : 'N/A' }}</p>
                                                    <p><strong>Fecha de Fin:</strong> {{ $cursos->fecha_fin ? $cursos->fecha_fin : 'N/A' }}</p>
                                                    <p><strong>Formato:</strong> {{ $cursos->formato ? $cursos->formato : 'N/A' }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <td>
                                <h4>NO HAY CURSOS REGISTRADOS</h4>
                            </td>
                        @endforelse


<!-- Modal Structure -->



                    </tbody>
                </table>
            @endif


            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


            <script>
                function mostrarAdvertencia(event) {
                    event.preventDefault();

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: 'Esta acción borrara a este curso. ¿Estás seguro de que deseas continuar?',
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








        </div>
    </div>


    @if (auth()->user()->hasRole('Estudiante'))
        @forelse ($inscritos as $inscrito)
            @if (auth()->user()->id == $inscrito->estudiante_id && $inscrito->cursos && $inscrito->cursos->deleted_at === null)
                <div class="w-full md:w-1/2 xl:w-1/3 p-3">

                    <a href="{{ route('Curso', $inscrito->cursos_id) }}" class="block bg-white border rounded shadow p-2">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded p-3 bg-blue-400"><i class="fa fa-bars fa-2x fa-fw fa-inverse"></i></div>
                            </div>
                            <div class="flex-1 text-right md:text-center">
                                <h3 class="atma text-3xl">{{ $inscrito->cursos->nombreCurso }} <span
                                        class="text-green-500"></span></h3>
                                <h5 class="alegreya uppercase"></h5>
                                <span class="inline-block mt-2">IR</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        @empty
            <h1>NO TIENES CURSOS ASIGNADOS</h1>
        @endforelse
    @endif

    @if (auth()->user()->hasRole('Docente'))
        @forelse ($cursos as $cursos)
            @if (auth()->user()->id == $cursos->docente_id)
                <div class="w-full md:w-1/2 xl:w-1/3 p-3">

                    <a href="{{ route('Curso', $cursos->id) }}" class="block bg-white border rounded shadow p-2">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded p-3 bg-blue-400"><i class="fa fa-bars fa-2x fa-fw fa-inverse"></i>
                                </div>
                            </div>
                            <div class="flex-1 text-right md:text-center">
                                <h3 class="atma text-3xl">{{ $cursos->nombreCurso }} <span class="text-green-500"></span>
                                </h3>
                                <h5 class="alegreya uppercase"></h5>
                                <span class="inline-block mt-2">IR</span>
                            </div>
                        </div>
                    </a>
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
