@section('titulo')
    Historial de Asistencia {{ $cursos->nombreCurso }}
@endsection




@section('content')
<div class="border p-3">
<a href="javascript:history.back()" class="btn btn-primary">
    &#9668; Volver
</a>
<br>
    <div class="col-lg-12 row">

        <form class="navbar-search navbar-search form-inline mr-3 d-none d-md-flex ml-lg-auto">
            {{ 'FECHA DE HOY : ' . now()->format('Y-m-d') }}



            @if (auth()->user()->hasRole('Docente') || auth()->user()->hasRole('Administrador'))

            //&nbsp;
            <a href="{{route('repA', $cursos->id)}}">Generar Reporte de Asistencias</a>

            @endif
            <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input class="form-control" placeholder="Buscar" type="text" id="searchInput">
            </div>
        </form>
    </div>
    <form action="{{route('historialAsistenciasPost', $cursos->id)}}" method="POST">
        @csrf
    <table class="table align-items-center table-flush">
        <thead class="thead-light">
            <tr>
                <th scope="col">Nro</th>
                <th scope="col">Nombre y Apellidos</th>
                <th scope="col">Tipo de asitencia</th>
                <th scope="col">Fecha</th>
            </tr>
        </thead>
        <tbody>
                @forelse ($asistencias as $asistencias)
                    @if (auth()->user()->hasRole('Docente') || auth()->user()->hasRole('Administrador'))
                    @if ($asistencias->curso_id == $cursos->id)
                    <tr>

                        <td scope="row">

                            {{ $loop->iteration }}

                        </td>

                    <td scope="row">


                            {{ $asistencias->inscritos->estudiantes->name }}
                            {{ $asistencias->inscritos->estudiantes->lastname1}}
                            {{ $asistencias->inscritos->estudiantes->lastname2}}
                    </td>

                    <input type="text" value="{{ $asistencias->id }}" name="asistencia[{{ $loop->index }}][id]" hidden>

                    <td>




                        <!-- Dropdown para seleccionar la asistencia -->
                        <div class="form-group">
                            <select name="asistencia[{{ $loop->index }}][tipo_asistencia]" class="form-control">
                                <option value="Presente" {{ $asistencias->tipoAsitencia == 'Presente'? 'selected' : '' }}>Presente</option>
                                <option value="Retraso" {{ $asistencias->tipoAsitencia == 'Retraso'? 'selected' : '' }}>Retraso</option>
                                <option value="Licencia" {{ $asistencias->tipoAsitencia == 'Licencia'? 'selected' : '' }}>Licencia</option>
                                <option value="Falta"{{ $asistencias->tipoAsitencia == 'Falta'? 'selected' : '' }}>Falta</option>
                            </select>
                        </div>


                    </td>

                    <td>
                            {{ $asistencias->fechaasistencia }}
                    </td>
                    @endif
                    @endif
                    @if (auth()->user()->hasRole('Estudiante') && auth()->user()->id == $asistencias->inscritos->estudiantes->id)
                    <tr>
                        <td scope="row">

                            {{ $loop->iteration }}

                        </td>
                        <td scope="row">
                            {{ $asistencias->inscritos->estudiantes->name}}
                            {{ $asistencias->inscritos->estudiantes->lastname1}}
                            {{ $asistencias->inscritos->estudiantes->lastname2}}
                        </td>


                        <td>

                            {{ $asistencias->tipoAsitencia }}


                        </td>
                        <td>

                            {{ $asistencias->fechaasistencia }}
                        </td>
                    </tr>
                    @endif



                @empty
                    <tr>

                        <td>

                            <h4>No hay asistencias creadas</h4>

                        </td>

                    </tr>
                @endforelse

        </tbody>


    </table>

    @if (auth()->user()->hasRole('Docente'))

    <div class="card">
        <div class="card-footer">
            <button type="submit"  class="btn btn-primary"
            @if ($cursos->fecha_fin && \Carbon\Carbon::now() > \Carbon\Carbon::parse($cursos->fecha_fin))
            disabled
            @else
            @endif
            >Guardar</button>
        </div>
    </div>

    </div>

    @endif
    </form>

    @if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
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
