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
                        <select name="curso" id="" class="mb-0 bg-transparent border-0">
                            @forelse ($cursos as $curso) <!-- Cambié el nombre de $cursos a $curso para evitar errores -->
                                <option value="{{ $curso->id }}">{{ ucfirst(strtolower($curso->nombreCurso)) }}</option>
                            @empty
                                <option value="">
                                    NO HAY CURSOS DISPONIBLES
                                </option>
                            @endforelse
                        </select>
                    @elseif (auth()->user()->hasRole('Docente'))
                        <select name="curso" id="" class="mb-0 bg-transparent border-0">
                            @forelse ($cursos as $curso)
                                @if (auth()->user()->id == $curso->docente_id)
                                    <option value="{{ $curso->id }}">{{ ucfirst(strtolower($curso->nombreCurso)) }}</option>
                                @endif
                            @empty
                                <option value="">
                                    NO TIENES CURSOS ASIGNADOS
                                </option>
                            @endforelse
                        </select>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <h3>Estudiante</h3>
                <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-column">
                    <!-- Campo de búsqueda -->
                    <input type="text" id="searchStudent" placeholder="Buscar estudiante..." class="form-control mb-2">

                    <!-- Lista de estudiantes con estilos para ocultar/mostrar -->
                    <div style="max-height: 300px; overflow-y: auto;">
                        <ul id="studentList" class="list-group w-100">
                            @forelse ($estudiantes as $estudiante)
                                <li class="list-group-item d-flex align-items-center">
                                    <input type="checkbox" name="estudiantes[]" value="{{ $estudiante->id }}" class="form-check-input ml-2">
                                    <span class="ml-5">{{ $estudiante->name . ' ' . $estudiante->lastname1 . ' ' . $estudiante->lastname2 }}</span>
                                </li>
                            @empty
                                <li class="list-group-item">NO HAY ESTUDIANTES REGISTRADOS</li>
                            @endforelse
                        </ul>
                        <!-- Mensaje de no resultados, inicialmente oculto -->
                        <p id="noResultsMessage" style="display: none; text-align: center; padding: 10px; font-weight: bold;">
                            NO SE ENCONTRARON RESULTADOS
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón para inscribir -->
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
    document.addEventListener('DOMContentLoaded', function() {
        var searchInput = document.getElementById('searchStudent');
        var studentList = document.getElementById('studentList');
        var students = studentList.getElementsByTagName('li');
        var noResultsMessage = document.getElementById('noResultsMessage');

        searchInput.addEventListener('keyup', function() {
            var searchTerm = searchInput.value.toLowerCase().trim();
            var hasResults = false;

            // Si el campo de búsqueda está vacío, muestra el mensaje para que el usuario ingrese algo
            if (searchTerm === '') {
                studentList.style.display = 'none';
                noResultsMessage.textContent = 'Coloque un nombre para buscar';
                noResultsMessage.style.display = 'block';
                return;
            }

            // Verifica los nombres de los estudiantes y muestra los que coinciden con el término de búsqueda
            for (var i = 0; i < students.length; i++) {
                var studentName = students[i].textContent.toLowerCase();
                if (studentName.includes(searchTerm)) {
                    students[i].style.display = 'flex'; // Mostrar estudiante
                    hasResults = true;
                } else {
                    students[i].style.display = 'none'; // Ocultar estudiante
                }
            }

            // Muestra el mensaje "NO SE ENCONTRARON RESULTADOS" si no hay coincidencias
            if (!hasResults) {
                studentList.style.display = 'none';
                noResultsMessage.textContent = 'NO SE ENCONTRARON RESULTADOS';
                noResultsMessage.style.display = 'block';
            } else {
                studentList.style.display = 'block';
                noResultsMessage.style.display = 'none';
            }
        });

        // Simulación de una pulsación de tecla al cargar la página para mostrar todos los estudiantes
        searchInput.dispatchEvent(new Event('keyup'));
    });
</script>

@extends('layout')
