@section('titulo')
    Lista de Asistencia {{ $cursos->nombreCurso }}
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
                    <i class="ni ni-key-25 text-info"></i> Asignación de Cursos
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
                <a class="nav-link " href="{{ route('pagos') }}">
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
        <div class="col-lg-12 row">
            <a href="{{ route('darasistencias', $cursos->id) }}">Ingresar Asistencia Persozalizada</a>
            <div class="navbar-search navbar-search form-inline mr-3 d-none d-md-flex ml-lg-auto">

                <form action="{{route('darasistenciasPostMultiple', $cursos->id)}}" method="POST">
                    @csrf

                    <label for="">Fecha: &nbsp;</label>
                    <input type="date" name="fecha_asistencia" id="fecha" value=""
                    @if ($cursos->fecha_fin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($cursos->fecha_fin))
                    disabled
                    @else
                    @endif
                    >
                    {{-- <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>

                <input class="form-control" placeholder="Buscar" type="date" placeholder="{{ now()->format('Y-m-d')}}">
            </div> --}}
        </div>
        </div>
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Nro</th>
                    <th scope="col">Nombre y Apellidos</th>
                    <th scope="col">Tipo de asitencia</th>
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
                                {{ $inscritos->estudiantes->name }}
                                {{ $inscritos->estudiantes->lastname1 }}
                                {{ $inscritos->estudiantes->lastname2 }}
                            </td>


                            <td>

                                <input type="text" value="{{ $inscritos->id }}"
                                    name="asistencia[{{ $loop->index }}][inscritos_id]" hidden>
                                <input type="text" value="{{ $cursos->id }}"
                                    name="asistencia[{{ $loop->index }}][curso_id]" hidden>


                                <!-- Dropdown para seleccionar la asistencia -->
                                <div class="form-group">
                                    <select  name="asistencia[{{ $loop->index }}][tipo_asistencia]" class="form-control"
                                        @if ($cursos->fecha_fin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($cursos->fecha_fin))
                                        disabled
                                        @else
                                        @endif>
                                        <option value="">Selecciona un tipo de asistencia</option>
                                        <option value="Presente">Presente</option>
                                        <option value="Retraso">Retraso</option>
                                        <option value="Licencia">Licencia</option>
                                        <option value="Falta">Falta</option>
                                    </select>
                                </div>
                                <!-- Botón para guardar la asistencia -->

                            </td>
                            <td>
                                {{-- <button type="submit" class="btn btn-primary">Guardar</button> --}}

                            </td>
                        </tr>
                    @endif


                @empty
                    <tr>

                        <td>

                            <h4>No hay alumnos inscritos</h4>

                        </td>

                    </tr>
                @endforelse
                <br>
                @if (auth()->user()->hasRole('Docente'))
                    <tr scope="row">

                        <td>
                            <button type="submit" class="btn btn-primary"
                            @if ($cursos->fecha_fin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($cursos->fecha_fin))
                            disabled
                            @else
                            @endif
                            >Guardar</button>

                        </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                    </tr>
                @endif
            </tbody>
            </form>
        </table>
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif


        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif



        <script>
            // Get the current date in the format "YYYY-MM-DD"
            function getCurrentDate() {
                const today = new Date();
                const year = today.getFullYear();
                let month = today.getMonth() + 1;
                let day = today.getDate();

                // Add leading zeros if needed
                month = month < 10 ? `0${month}` : month;
                day = day < 10 ? `0${day}` : day;

                return `${year}-${month}-${day}`;
            }

            // Set the initial value of the date input to the current date
            document.getElementById('fecha').value = getCurrentDate();
        </script>
    @endsection

    @include('layout')
