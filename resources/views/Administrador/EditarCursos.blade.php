@extends('layout')

@section('titulo', 'Editar Curso')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <a href="javascript:history.back()" class="btn btn-sm btn-primary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <h6 class="m-0 font-weight-bold text-primary">Editar Curso: {{ $cursos->nombreCurso }}</h6>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
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

            <form action="{{ route('editarCursoPost', $cursos->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <!-- Información Básica -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Nombre del Curso</label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                   value="{{ $cursos->nombreCurso }}" required>
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion"
                                      rows="3" required>{{ $cursos->descripcionC }}</textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nota">Nota de Aprobación</label>
                                <input type="number" class="form-control" id="nota" name="nota"
                                       value="{{ $cursos->notaAprobacion ?? 51 }}" min="0" max="100">
                                <small class="text-muted">Por defecto: 51</small>
                            </div>
                        </div>
                    </div>

                    <!-- Fechas y Tipo -->
                    <div class="col-md-6">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="fecha_ini">Fecha Inicio</label>
                                <input type="{{ $cursos->tipo == 'congreso' ? 'datetime-local' : 'date' }}"
                                       class="form-control" id="fecha_ini" name="fecha_ini"
                                       value="{{ old('fecha_ini', $cursos->fecha_ini ? \Carbon\Carbon::parse($cursos->fecha_ini)->format($cursos->tipo == 'congreso' ? 'Y-m-d\TH:i' : 'Y-m-d') : '') }}"
                                       @if(auth()->user()->hasRole('Docente')) readonly @endif>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="fecha_fin">Fecha Fin</label>
                                <input type="{{ $cursos->tipo == 'congreso' ? 'datetime-local' : 'date' }}"
                                       class="form-control" id="fecha_fin" name="fecha_fin"
                                       value="{{ old('fecha_fin', $cursos->fecha_fin ? \Carbon\Carbon::parse($cursos->fecha_fin)->format($cursos->tipo == 'congreso' ? 'Y-m-d\TH:i' : 'Y-m-d') : '') }}"
                                       @if(auth()->user()->hasRole('Docente')) readonly @endif>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="formato">Formato</label>
                                <select class="form-control" id="formato" name="formato">
                                    <option value="Presencial" {{ $cursos->formato === 'Presencial' ? 'selected' : '' }}>Presencial</option>
                                    <option value="Virtual" {{ $cursos->formato === 'Virtual' ? 'selected' : '' }}>Virtual</option>
                                    <option value="Híbrido" {{ $cursos->formato === 'Híbrido' ? 'selected' : '' }}>Híbrido</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tipo">Tipo</label>
                                <select class="form-control" id="tipo" name="tipo">
                                    <option value="curso" {{ $cursos->tipo === 'curso' ? 'selected' : '' }}>Curso</option>
                                    <option value="congreso" {{ $cursos->tipo === 'congreso' ? 'selected' : '' }}>Congreso</option>
                                </select>
                            </div>
                        </div>

                        @if(auth()->user()->hasRole('Administrador'))
                        <div class="form-group">
                            <label for="docente_id">Docente</label>
                            <select class="form-control" id="docente_id" name="docente_id">
                                @foreach($docente as $doc)
                                <option value="{{ $doc->id }}" {{ $cursos->docente_id == $doc->id ? 'selected' : '' }}>
                                    {{ $doc->name }} {{ $doc->lastname1 }} {{ $doc->lastname2 }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @else
                        <input type="hidden" name="docente_id" value="{{ auth()->user()->id }}">
                        @endif
                    </div>
                </div>

                <!-- Niveles y Edades -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="edad_id">Edad Dirigida</label>
                            <input type="text" class="form-control" id="edad_id" name="edad_id"
                                   value="{{ $cursos->edad_dirigida }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nivel_id">Niveles</label>
                            <input type="text" class="form-control" id="nivel_id" name="nivel_id"
                                   value="{{ $cursos->nivel }}">
                        </div>
                    </div>
                </div>

                <!-- Archivo de Contenido (Docente) -->
                @if(auth()->user()->hasRole('Docente'))
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="archivo">Tabla de Contenidos</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="archivo" name="archivo">
                                <label class="custom-file-label" for="archivo">
                                    {{ $cursos->archivoContenidodelCurso ? 'Cambiar archivo' : 'Seleccionar archivo' }}
                                </label>
                            </div>

                            @if($cursos->archivoContenidodelCurso)
                            <div class="mt-3">
                                <p>Archivo actual:</p>
                                <div class="embed-responsive embed-responsive-16by9" style="max-height: 250px;">
                                    <embed class="embed-responsive-item"
                                           src="{{ asset('storage/' . $cursos->archivoContenidodelCurso) }}"
                                           type="application/pdf">
                                </div>
                                <a href="{{ asset('storage/' . $cursos->archivoContenidodelCurso) }}"
                                   class="btn btn-sm btn-primary mt-2" target="_blank">
                                    <i class="fas fa-download"></i> Descargar
                                </a>
                            </div>
                            @else
                            <div class="alert alert-info mt-3">
                                No se ha cargado ningún archivo todavía
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <div class="row mt-4">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save"></i> Guardar Cambios
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Cambiar el label del input file cuando se selecciona un archivo
document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = document.getElementById("archivo").files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});

// Cambiar el tipo de input de fecha según el tipo de curso
document.getElementById('tipo').addEventListener('change', function() {
    var tipo = this.value;
    var fechaIni = document.getElementById('fecha_ini');
    var fechaFin = document.getElementById('fecha_fin');

    if(tipo === 'congreso') {
        fechaIni.type = 'datetime-local';
        fechaFin.type = 'datetime-local';
    } else {
        fechaIni.type = 'date';
        fechaFin.type = 'date';
    }
});
</script>
@endsection