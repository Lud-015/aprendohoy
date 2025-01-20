@section('titulo')
    Lista de Entrega {{ $tareas->titulo_tarea }}
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
                <a class="nav-link " href="./examples/tables.html">
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('input[type="number"]').forEach(function(input) {
            let cachedValue = localStorage.getItem(input.name);
            if (cachedValue !== null) {
                input.value = cachedValue;
            }

            input.addEventListener('input', function() {
                localStorage.setItem(input.name, input.value);
                window.isFormModified = true;
            });
        });
    });

    window.onbeforeunload = function(event) {
        if (window.isFormModified) {
            const message = "Tiene cambios sin guardar. ¿Está seguro de que quiere salir de la página?";
            event.returnValue = message;
            return message;
        }
    };
</script>

@section('content')
<div class="border p-3">
<a href="javascript:history.back()" class="btn btn-primary">
    &#9668; Volver
</a>
<br>
<br>
    <div class="col-lg-12 row">

        <form class="navbar-search navbar-search form-inline mr-3 d-none d-md-flex ml-lg-auto">
            <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input class="form-control" placeholder="Buscar" type="text" id="searchInput">
            </div>
        </form>
    </div>
    <table class="table align-items-center table-flush">
        <thead class="thead-light">
            <tr>
                <th scope="col">Nro</th>
                <th scope="col">Nombre y Apellidos</th>
                <th scope="col">Calificar</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>

        </thead>
        <form action="{{route('calificarT', $tareas->id)}}" method="POST">
            @csrf
            <tbody>

                @foreach ($inscritos as $inscritos)
                     @if ($inscritos->cursos_id ==  $tareas->cursos_id)

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



                            <input  type="number" required   name="entregas[{{$loop->index}}][notaTarea] " min="0" max="{{$tareas->puntos}}"



                            @if ($tareas->cursos->fecha_fin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($tareas->cursos->fecha_fin) || $tareas->fecha_vencimiento && \Carbon\Carbon::now() > \Carbon\Carbon::parse($tareas->fecha_vencimiento))

                            disabled


                            @else
                            @endif



                            @forelse ($inscritos->notatarea as $item)
                            @if ($item->tarea_id == $tareas->id)
                                value="{{$item->nota}}"
                            @endif
                            @empty
                            value="0"
                            @endforelse>

                            <input  type="number" name="entregas[{{$loop->index}}][id]"

                            @forelse ($inscritos->notatarea as $item)
                            @if ($item->tarea_id == $tareas->id)
                                value="{{$item->id}}"
                            @endif
                            @empty
                                value="null"
                            @endforelse
                            hidden>

                            {{-- <input type="number" name="entregas[{{$loop->index}}][notaTarea] " min="0" max="{{$tareas->puntos}}" value="0"> --}}
                            <input type="text" name="entregas[{{$loop->index}}][id_tarea]" value="{{$tareas->id}}" hidden>
                            <input type="text" name="entregas[{{$loop->index}}][id_inscripcion]" value="{{$inscritos->id}}" hidden>

                        </td>

                        <td>

                        @forelse ($entregasTareas as $item)

                            @if ($item->estudiante_id == $inscritos->estudiante_id && $inscritos->cursos_id ==  $tareas->cursos_id )

                            <a href="{{ asset('storage/' . $item->ArchivoEntrega) }}"> VER TAREA </a>
                            <br>

                            @else

                            <span class="badge badge-danger">NO HIZO NINGUNA ENTREGA</span>
                            @break

                            @endif

                            @empty

                            <span class="badge badge-danger">NO HIZO NINGUNA ENTREGA</span>


                        @endforelse
                        </td>

                        <td>
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#exampleModal{{ $inscritos->id }}">
                                    Retroalimentar
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal{{ $inscritos->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel">Retroalimentar Tarea de
                                                    {{ $inscritos->estudiantes->name }}
                                                    {{ $inscritos->estudiantes->lastname1 }}
                                                    {{ $inscritos->estudiantes->lastname2 }}</h4>

                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Retroalimentacion anterior:
                                                <br>
                                                @forelse ($inscritos->notatarea as $nota)
                                            @if ($nota->tarea_id == $tareas->id)
                                                {{$nota->retroalimentacion}}
                                            @endif
                                            @empty
                                            @endforelse

                                            <br><br>

                                            @if ($tareas->cursos->fecha_fin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($tareas->cursos->fecha_fin) || $tareas->fecha_vencimiento && \Carbon\Carbon::now() > \Carbon\Carbon::parse($tareas->fecha_vencimiento))


                                            @else
                                            <textarea id="autoSaveTextarea retroalimentacion_{{$loop->index}}" class="styled-textarea" name="entregas[{{$loop->index}}][retroalimentacion]" size="50" maxlength="50" value="" placeholder="Escribe la retroaliamentacion aqui..."></textarea>
                                            @endif
                                            {{-- <input id="retroalimentacion_{{$loop->index}}" name="entregas[{{$loop->index}}][retroalimentacion]" size="50" maxlength="50" value=""></input> --}}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>

                        </td>

                    @endif
                @endforeach






            </tbody>

        </table>

        <div class="card">
            <div class="card-footer">
                @if ($tareas->cursos->fecha_fin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($tareas->cursos->fecha_fin) || $tareas->fecha_vencimiento && \Carbon\Carbon::now() > \Carbon\Carbon::parse($tareas->fecha_vencimiento))

                <h3>Ya no  se puede calificar esta actividad</h3>

                @else
                <input type="submit" class="btn btn-custom" value="Calificar">
                @endif
            </div>
        </div>
    </form>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


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



@endsection

@include('layout')
