@section('titulo')
    Asignar Cursos
@endsection



@section('content')
<div class="container my-4">
    <h1 class="mb-4">Asignar Cursos a Estudiantes</h1>
    <div class="row mt-4">
        <div class="col-md-12">
            <form action="{{ route('inscribir') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="estudiante_id">Seleccionar Estudiante</label>
                    <select class="form-control" id="estudiante_id" name="estudiante_id" required>
                        <option value="">Seleccione un estudiante</option>
                        @foreach($estudiantes as $estudiante)
                            <option value="{{ $estudiante->id }}">{{ $estudiante->name }} {{ $estudiante->lastname1 }} {{ $estudiante->lastname2 }} ({{ $estudiante->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="curso_id">Seleccionar Curso</label>
                    <select class="form-control" id="curso_id" name="curso_id" required>
                        <option value="">Seleccione un curso</option>
                        @foreach($cursos as $curso)
                            <option value="{{ $curso->id }}">{{ $curso->nombreCurso }} - {{ $curso->fecha_ini }} a {{ $curso->fecha_fin }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Inscribir</button>
            </form>
        </div>
    </div>
</div>
@endsection






@extends('layout')
