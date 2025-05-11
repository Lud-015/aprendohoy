<button class="m-3 btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#crearMultiplesPreguntasModal">
    <i class="fas fa-plus"></i> Crear Múltiples Preguntas
</button>

<table class="table table-striped table-hover align-middle">
    <thead>
        <tr>
            <th>#</th>
            <th>Pregunta</th>
            <th>Tipo</th>
            <th>Puntos</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($preguntas as $pregunta)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pregunta->enunciado }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $pregunta->tipo)) }}</td>
                <td>{{ $pregunta->puntaje }}</td>
                <td>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                        data-bs-target="#editarPreguntaModal-{{ $pregunta->id }}">
                        <i class="fas fa-edit"></i> Editar
                    </button>
                    <form method="POST" action="{{ route('pregunta.delete', $pregunta->id) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>