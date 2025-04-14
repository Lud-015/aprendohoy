


@section('content')

<div class="container mt-4">
    <a href="javascript:history.back()" class="btn btn-outline-primary mb-3">
        &#9668; Volver
    </a>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Creación de Evaluación</h4>
            <small>Curso: {{$cursos->nombreCurso}}</small>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('CrearEvaluacionPost', $cursos->id) }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="cursos_id" value="{{ $cursos->id }}">

                <div class="mb-3">
                    <label for="taskTitle" class="form-label">Título de la Evaluación:</label>
                    <input type="text" class="form-control" id="taskTitle" name="tituloEvaluacion" value="{{ old('tituloEvaluacion') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tema de la Evaluación:</label>
                    <select name="tema_id" class="form-select" required>
                        @forelse ($cursos->temas as $tema)
                            <option value="{{ $tema->id }}">{{ $tema->titulo_tema }}</option>
                        @empty
                            <option value="">No hay temas creados</option>
                        @endforelse
                    </select>
                </div>

                <div class="mb-3">
                    <label for="taskDescription" class="form-label">Descripción de la Evaluación:</label>
                    <textarea class="form-control" id="taskDescription" name="evaluacionDescripcion" rows="4" required>{{ old('evaluacionDescripcion') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="fechaHabilitacion" class="form-label">Fecha de Habilitación:</label>
                    <input type="date" class="form-control" id="fechaHabilitacion" name="fechaHabilitacion" value="{{ old('fechaHabilitacion') }}" required>
                </div>

                <div class="mb-3">
                    <label for="fechaVencimiento" class="form-label">Fecha de Vencimiento:</label>
                    <input type="date" class="form-control" id="fechaVencimiento" name="fechaVencimiento" value="{{ old('fechaVencimiento') }}" required>
                </div>

                <div class="mb-3">
                    <label for="points" class="form-label">Puntos de Calificación:</label>
                    <input type="number" class="form-control" id="points" name="puntos" value="{{ old('puntos') }}" required>
                </div>

                <div class="mb-4">
                    <label for="fileUpload" class="form-label">Adjuntar Archivo:</label>
                    <input type="file" class="form-control" id="fileUpload" name="evaluacionArchivo">
                </div>

                <button type="submit" class="btn btn-success w-100">Guardar Evaluación</button>
            </form>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mt-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

@endsection



@include('layout')

