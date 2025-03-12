@section('titulo')
    Lista de Entrega {{ $evaluaciones->titulo_tarea }}
@endsection



@section('content')
<div class="border p-3">
<a href="javascript:history.back()" class="btn btn-primary">
    &#9668; Volver
</a>
<br>
    <div class="col-lg-12 row">

        <form class="navbar-search navbar-search form-inline mr-3 d-none d-md-flex ml-lg-auto">
            <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input class="form-control" placeholder="Buscar" type="text">
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
        <form action="{{route('calificarE',  $evaluaciones->id)}}" method="POST">
            @csrf
            <tbody>

                @foreach ($inscritos as $inscritos)
                    @if ($inscritos->cursos_id ==  $evaluaciones->cursos_id)

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
                            <input  type="number" required name="entregas[{{$loop->index}}][notaEvaluacion] " min="0" max="{{$evaluaciones->puntos}}"

                            @forelse ($inscritos->notaevaluacion as $item)
                            @if ($item->evaluaciones_id == $evaluaciones->id)
                                value="{{$item->nota}}"
                            @endif
                            @empty
                            value="0"

                            @if ($evaluaciones->cursos->fecha_fin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($evaluaciones->cursos->fecha_fin) || $evaluaciones->fecha_vencimiento && \Carbon\Carbon::now() > \Carbon\Carbon::parse($evaluaciones->fecha_vencimiento))
                            disabled
                            @else
                            @endif



                            @endforelse>

                            <input  type="number" name="entregas[{{$loop->index}}][id]"

                            @forelse ($inscritos->notaevaluacion as $item)
                            @if ($item->evaluaciones_id == $evaluaciones->id)
                                value="{{$item->id}}"
                            @endif
                            @empty
                                value="null"
                            @endforelse
                            hidden>







                            <input type="text" name="entregas[{{$loop->index}}][id_evaluacion]" value="{{$evaluaciones->id}}" hidden>

                            <input type="text" name="entregas[{{$loop->index}}][id_inscripcion]" value="{{$inscritos->id}}" hidden>

                        </td>

                        <td>
                        @forelse ($entregasEvaluaciones as $item)


                            @if ($item->estudiante_id == $inscritos->estudiante_id && $inscritos->cursos_id ==  $evaluaciones->cursos_id )



                            <a href="{{ asset('storage/' . $item->ArchivoEntrega) }}"> VER EVALUACION </a>
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
                                                <h4 class="modal-title" id="exampleModalLabel">Retroalimentar Evaluacion de
                                                    {{ $inscritos->estudiantes->name }}
                                                    {{ $inscritos->estudiantes->lastname1 }}
                                                    {{ $inscritos->estudiantes->lastname2 }}</h4>

                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <label for="">Retroalimentacion Anterior:</label>
                                                <br>
                                                @forelse ($inscritos->notaevaluacion as $nota)
                                                @if ($nota->evaluaciones_id == $evaluaciones->id)
                                                    {{$nota->retroalimentacion}}
                                                @endif
                                                @empty
                                            @endforelse
                                            <br>
                                            <br>

                                            @if ($evaluaciones->cursos->fecha_fin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($evaluaciones->cursos->fecha_fin) || $evaluaciones->fecha_vencimiento && \Carbon\Carbon::now() > \Carbon\Carbon::parse($evaluaciones->fecha_vencimiento))
                                            @else

                                            <input id="retroalimentacion_{{$loop->index}}" name="entregas[{{$loop->index}}][retroalimentacion]" value="" size="50">
                                            @endif


                                                </input>


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



        <div class="card p-2">

            @if ($evaluaciones->cursos->fecha_fin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($evaluaciones->cursos->fecha_fin) || $evaluaciones->fecha_vencimiento && \Carbon\Carbon::now() > \Carbon\Carbon::parse($evaluaciones->fecha_vencimiento))
            @else
            <div class="card-footer">
                <input type="submit" class="btn btn-custom" value="Calificar">
            </div>
            @endif
        </div>




        </form>


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


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif







@endsection

@include('layout')
