@section('titulo')
    Crear Curso
@endsection




@section('content')

<div class="col-xl-12">
    <a href="{{ route('Inicio') }}" class="m-2 btn btn-sm btn-primary">
        &#9668; Volver
    </a>

    <form class="form ml-3 col-10" action="{{ route('CrearCursoPost') }}" method="POST">
        @csrf
        <div class="border p-3 mb-2 mt-2">
            <!-- Datos básicos del curso -->
            <div class="form-group">
                <label for="nombre">Nombre Curso <span class="text-danger">*</span></label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control custom-width" required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción Curso (Opcional)</label>
                <input type="text" name="descripcion" value="{{ old('descripcion') }}" class="form-control">
            </div>

            <div style="display: flex; align-items: center;" class="mb-4">
                <div class="mr-3">
                    <label for="fecha_ini">Fecha Inicio <span class="text-danger">*</span></label>
                    <input type="date" name="fecha_ini" value="{{ old('fecha_ini') }}" class="form-control" required>
                </div>
                <div class="ml-3">
                    <label for="fecha_fin">Fecha Fin <span class="text-danger">*</span></label>
                    <input type="date" name="fecha_fin" value="{{ old('fecha_fin') }}" class="form-control" required>
                </div>
            </div>

            <!-- Formato y docente -->
            <div style="display: flex; align-items: center;" class="mb-4">
                <div class="mr-3">
                    <label for="formato">Formato</label>
                    <select name="formato" class="form-control w-auto">
                        <option value="Presencial" {{ old('formato') == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                        <option value="Virtual" {{ old('formato') == 'Virtual' ? 'selected' : '' }}>Virtual</option>
                        <option value="Híbrido" {{ old('formato') == 'Híbrido' ? 'selected' : '' }}>Híbrido</option>
                    </select>
                </div>
                <div class="mr-3">
                    <label for="tipo">Tipo</label>
                    <select name="tipo" class="form-control w-auto">
                        <option value="curso" {{ old('tipo') == 'curso' ? 'selected' : '' }}>Curso</option>
                        <option value="congreso" {{ old('tipo') == 'congreso' ? 'selected' : '' }}>Congreso</option>
                    </select>
                </div>
                <div class="ml-3">
                    <label for="docente_id">Docente <span class="text-danger">*</span></label>
                    <span class="text-danger">* Si no está registrado el docente, <a href="{{ route('CrearDocente') }}">Haz clic aquí</a></span>
                    <select name="docente_id" class="form-control w-auto">
                        @forelse ($docente as $docente)
                            <option value="{{ $docente->id }}" {{ old('docente_id') == $docente->id ? 'selected' : '' }}>
                                {{ $docente->name }} {{ $docente->lastname1 }} {{ $docente->lastname2 }}
                            </option>
                        @empty
                            <option value="" disabled>NO HAY DOCENTES REGISTRADOS</option>
                        @endforelse
                    </select>
                </div>
            </div>

            <!-- Edad y niveles -->
            <div style="display: flex; align-items: center;" class="mb-4">
                <div class="mr-3">
                    <label for="edad_id">Edad estudiantes. (rango aproximado)</label>
                    <input type="text" name="edad_id" class="form-control">
                </div>
                <div class="ml-3">
                    <label for="nivel_id">Niveles</label>
                    <input type="text" name="nivel_id" class="form-control">
                </div>
            </div>

            <!-- Horarios dinámicos -->

            <br>
            <input class="btn btn-success" type="submit" value="Guardar">
        </div>
    </form>
</div>


    <script>
        document.getElementById('add-horario').addEventListener('click', function() {
            const container = document.getElementById('horarios-container');
            const newHorario = container.firstElementChild.cloneNode(true);
            newHorario.querySelectorAll('input, select').forEach(input => input.value = '');
            container.appendChild(newHorario);
        });

        document.getElementById('horarios-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-horario')) {
                e.target.closest('.horario').remove();
            }
        });
    </script>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <h2 class="bg-danger alert-danger">{{ $error }}</h2>
        @endforeach
    @endif
@endsection


@include('layout')
