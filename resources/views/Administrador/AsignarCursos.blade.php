@section('titulo')
    Asignar Cursos
@endsection



@section('content')
<form method="POST" action="{{ route('inscribir') }}">
    @csrf
    <div class="card-body p-3">
        <div class="row">
            <div class="col-md-6 mb-md-0 mb-4">
                <h3>Curso</h3>
                <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                    @if (auth()->user()->hasRole('Administrador'))
                        <select name="curso" class="mb-0 bg-transparent border-0">
                            @forelse ($cursos as $curso)
                                <option value="{{ $curso->id }}">{{ ucfirst(strtolower($curso->nombreCurso)) }}</option>
                            @empty
                                <option value="">NO HAY CURSOS DISPONIBLES</option>
                            @endforelse
                        </select>
                    @elseif (auth()->user()->hasRole('Docente'))
                        <select name="curso" class="mb-0 bg-transparent border-0">
                            @forelse ($cursos as $curso)
                                @if (auth()->user()->id == $curso->docente_id)
                                    <option value="{{ $curso->id }}">{{ ucfirst(strtolower($curso->nombreCurso)) }}</option>
                                @endif
                            @empty
                                <option value="">NO TIENES CURSOS ASIGNADOS</option>
                            @endforelse
                        </select>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <h3>Estudiante</h3>
                <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-column">
                    <input type="text" id="searchStudent" placeholder="Buscar estudiante..." class="form-control mb-2">
                    <div style="max-height: 300px; overflow-y: auto;">
                        <ul id="studentList" class="list-group w-100">
                            @forelse ($estudiantes as $estudiante)
                                <li class="list-group-item d-flex align-items-center">
                                    <input type="checkbox" name="estudiantes[]" value="{{ $estudiante->id }}" class="form-check-input ml-2">
                                    <span class="ml-5">{{ $estudiante->name . ' ' . $estudiante->lastname1 . ' ' . $estudiante->lastname2 }}</span>
                                </li>
                            @empty
                                <li class="list-group-item">NO HAY ESTUDIANTES DISPONIBLES PARA INSCRIBIR</li>
                            @endforelse
                        </ul>
                        <p id="noResultsMessage" style="display: none; text-align: center; padding: 10px; font-weight: bold;">
                            NO SE ENCONTRARON RESULTADOS
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <br><br>
        <input class="btn btn-lg btn-success" type="submit" value="Inscribir Alumno">
    </div>
</form>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <h2 class="bg-danger alert-danger">{{ $error }}</h2>
    @endforeach
@endif
@endsection

<script>
    document.getElementById('searchStudent').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const studentList = document.getElementById('studentList').getElementsByTagName('li');
        let noResults = true;

        for (let i = 0; i < studentList.length; i++) {
            const studentName = studentList[i].textContent.toLowerCase();
            if (studentName.includes(searchValue)) {
                studentList[i].style.display = '';
                noResults = false;
            } else {
                studentList[i].style.display = 'none';
            }
        }

        document.getElementById('noResultsMessage').style.display = noResults ? 'block' : 'none';
    });
</script>

@extends('layout')
