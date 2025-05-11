@section('titulo')
    Ranking de Cuestionarios
@endsection

@section('content')
    <div class="container mt-4">

        @if (Auth::user()->hasRole('Estudiante'))
            <!-- Sección para el Estudiante -->
            <h3 class="mt-4">Tus Mejores Intentos</h3>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cuestionario</th>
                        <th>Nota</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mejoresIntentos as $intento)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $intento->cuestionario->actividad->titulo }}</td>
                            <td>{{ $intento->nota ? $intento->nota : 'Sin Nota' }}</td>
                            <td>{{ $intento->finalizado_en ? $intento->finalizado_en->format('d/m/Y H:i') : 'Salió del cuestionario' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No tienes intentos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @elseif (Auth::user()->hasRole('Docente'))
            <div class="container mt-4">
                <h2>Ranking de Estudiantes para del Cuestionario: {{ $cuestionario->titulo }}</h2>

                <table id="rankingTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Estudiante</th>
                            <th>Nota</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cuestionario->intentos as $intento)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $intento->inscrito->estudiantes->name }}
                                    {{ $intento->inscrito->estudiantes->lastname1 }}
                                    {{ $intento->inscrito->estudiantes->lastname2 }}</td>
                                <td>{{ $intento->nota !== null ? $intento->nota : 'Sin nota' }}</td>
                                <td>{{ $intento->finalizado_en ? $intento->finalizado_en->format('d/m/Y H:i') : 'Salió del cuestionario' }}
                                </td>
                                <td>
                                    <a href="{{ route('cuestionarios.revisarIntento', [$cuestionario->id, $intento->id]) }}"
                                        class="btn btn-primary btn-sm">
                                        Revisar
                                    </a>
                                    <form action="{{ route('intentos.eliminar', $intento->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este intento?')">
                                            Eliminar Intento
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No hay intentos registrados para este cuestionario.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif

    @endsection

    @include('layout')


    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- jQuery (necesario para DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#rankingTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json" // Traducción al español
                },
                order: [
                    [2, 'desc']
                ], // Ordenar por la columna de nota (índice 2) de forma descendente
                pageLength: 10, // Mostrar 10 filas por página
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#rankingTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json" // Traducción al español
                },
                order: [
                    [2, 'desc']
                ], // Ordenar por la columna de nota (índice 2) de forma descendente
                pageLength: 10, // Mostrar 10 filas por página
            });
        });
    </script>
