@extends('layout')

@section('titulo')
    Lista de Entrega: {{ $evaluaciones->titulo_tarea }}
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <a href="javascript:history.back()" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <h6 class="m-0 font-weight-bold text-primary">Evaluación: {{ $evaluaciones->titulo_tarea }}</h6>
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Buscar estudiante..."
                           id="searchInput">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('calificarE', $evaluaciones->id) }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%">#</th>
                                <th width="30%">Estudiante</th>
                                <th width="15%">Calificación (0-{{ $evaluaciones->puntos }})</th>
                                <th width="25%">Entrega</th>
                                <th width="25%">Retroalimentación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inscritos as $index => $inscrito)
                                @if ($inscrito->cursos_id == $evaluaciones->cursos_id)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $inscrito->estudiantes->name }}
                                            {{ $inscrito->estudiantes->lastname1 }}
                                            {{ $inscrito->estudiantes->lastname2 }}
                                        </td>
                                        <td>
                                            @php
                                                $notaExistente = $inscrito->notaevaluacion
                                                    ->where('evaluaciones_id', $evaluaciones->id)
                                                    ->first();
                                                $vencido = ($evaluaciones->cursos->fecha_fin && now() > $evaluaciones->cursos->fecha_fin) ||
                                                          ($evaluaciones->fecha_vencimiento && now() > $evaluaciones->fecha_vencimiento);
                                            @endphp

                                            <input type="number" class="form-control"
                                                   name="entregas[{{$index}}][notaEvaluacion]"
                                                   min="0" max="{{$evaluaciones->puntos}}"
                                                   value="{{ $notaExistente->nota ?? 0 }}"
                                                   {{ $vencido ? 'disabled' : 'required' }}>

                                            <input type="hidden" name="entregas[{{$index}}][id]"
                                                   value="{{ $notaExistente->id ?? 'null' }}">
                                            <input type="hidden" name="entregas[{{$index}}][id_evaluacion]"
                                                   value="{{ $evaluaciones->id }}">
                                            <input type="hidden" name="entregas[{{$index}}][id_inscripcion]"
                                                   value="{{ $inscrito->id }}">
                                        </td>
                                        <td>
                                            @php
                                                $entrega = $entregasEvaluaciones->firstWhere('estudiante_id', $inscrito->estudiante_id);
                                            @endphp

                                            @if($entrega)
                                                <a href="{{ asset('storage/' . $entrega->ArchivoEntrega) }}"
                                                   class="btn btn-sm btn-info" target="_blank">
                                                    <i class="fas fa-eye"></i> Ver Entrega
                                                </a>
                                            @else
                                                <span class="badge badge-danger">No entregado</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($notaExistente && $notaExistente->retroalimentacion)
                                                <small class="text-muted">Anterior: {{ $notaExistente->retroalimentacion }}</small>
                                                <br>
                                            @endif

                                            @if(!$vencido)
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                        data-target="#feedbackModal{{$index}}">
                                                    <i class="fas fa-comment"></i> Retroalimentar
                                                </button>

                                                <!-- Modal de Retroalimentación -->
                                                <div class="modal fade" id="feedbackModal{{$index}}" tabindex="-1" role="dialog"
                                                     aria-labelledby="feedbackModalLabel{{$index}}" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="feedbackModalLabel{{$index}}">
                                                                    Retroalimentación para {{ $inscrito->estudiantes->name }}
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="retroalimentacion{{$index}}">Comentarios:</label>
                                                                    <textarea class="form-control" id="retroalimentacion{{$index}}"
                                                                              name="entregas[{{$index}}][retroalimentacion]" rows="3"
                                                                              placeholder="Escribe aquí tus comentarios...">{{ $notaExistente->retroalimentacion ?? '' }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">Período cerrado</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if(!$vencido)
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save"></i> Guardar Calificaciones
                        </button>
                    </div>
                @else
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-exclamation-triangle"></i> El período de calificación ha finalizado.
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Búsqueda en tiempo real
    $("#searchInput").on("keyup", function() {
        const value = $(this).val().toLowerCase();
        $("#dataTable tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Inicializar tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endsection