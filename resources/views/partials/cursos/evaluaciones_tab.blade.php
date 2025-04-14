<div class="tab-pane fade" id="tab-evaluaciones">
    <h3>Evaluaciones</h3>
    @if (auth()->user()->hasRole('Docente'))
        <div class="mb-3">
            <a href="{{ route('CrearEvaluacion', [$cursos->id]) }}"
                class="btn btn-primary btn-sm"> + Nueva Evaluación</a>
            <a href="{{ route('evaluacionesEliminadas', [$cursos->id]) }}"
                class="btn btn-info btn-sm">Evaluaciones Eliminadas</a>
        </div>
    @endif
    @forelse ($evaluaciones as $evaluacion)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $evaluacion->titulo_evaluacion }}</h5>
                <p>Creado: {{ $evaluacion->fecha_habilitacion }} | Vence:
                    {{ $evaluacion->fecha_vencimiento }}</p>
                <a href="{{ route('VerEvaluacion', [$evaluacion->id]) }}"
                    class="btn btn-primary btn-sm">Ir a Evaluación</a>
                @if (auth()->user()->hasRole('Docente'))
                    <a href="{{ route('calificarE', $evaluacion->id) }}"
                        class="btn btn-info btn-sm">Calificar</a>
                    <a href="{{ route('editarEvaluacion', $evaluacion->id) }}"
                        class="btn btn-info btn-sm">Editar</a>
                    <a href="{{ route('quitarEvaluacion', $evaluacion->id) }}"
                        class="btn btn-danger btn-sm" onclick="mostrarAdvertencia(event)">Eliminar</a>
                @endif
            </div>
        </div>
    @empty
        <p>No hay evaluaciones asignadas.</p>
    @endforelse
</div>