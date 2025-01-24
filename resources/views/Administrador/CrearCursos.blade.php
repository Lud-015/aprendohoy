@section('titulo')
    Crear Curso
@endsection




@section('content')
    <style>

    </style>
    <div class="col-xl-12">
        <a href="{{ route('Inicio') }}" class="btn btn-sm btn-primary">
            &#9668; Volver
        </a>
        <a href="{{ route('crearNivel') }}" class="btn btn-sm btn-success">
            Añadir Nivel
        </a>
        <a href="{{ route('crearEdad') }}" class="btn btn-sm btn-success">
            Añadir rango de edad
        </a>

        <form class="form ml-3 col-5" action="{{ route('CrearCursoPost') }}" method="POST">
            @csrf
            <div class="border p-3 mb-2 mt-2">
                <!-- Datos básicos del curso -->
                <div class="form-group">
                    <label for="nombre">Nombre Curso</label>
                    <ul class="text-danger">
                        <li>El campo es obligatorio.</li>
                    </ul>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control custom-width">
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción Curso (Opcional)</label>
                    <input type="text" name="descripcion" value="{{ old('descripcion') }}" class="form-control bv -ml-3">
                </div>

                <div style="display: flex; align-items: center;" class="mb-4">
                    <div class="mr-8">
                        <label for="fecha_ini">Fecha Inicio</label><span class="text-danger">*</span>
                        <br>
                        <input type="date" name="fecha_ini" value="{{ old('fecha_ini') }}" class="form-control">
                    </div>
                    <div class="ml-3">
                        <label for="fecha_fin">Fecha Fin</label><span class="text-danger">*</span>
                        <br>
                        <input type="date" name="fecha_fin" value="{{ old('fecha_fin') }}" class="form-control">
                    </div>
                </div>

                <!-- Formato y docente -->
                <div style="display: flex; align-items: center;" class="mb-4">
                    <div class="mr-8">
                        <label for="formato">Formato</label>
                        <select name="formato" class="form-control w-auto">
                            <option value="Presencial" {{ old('formato') == 'Presencial' ? 'selected' : '' }}>Presencial
                            </option>
                            <option value="Virtual" {{ old('formato') == 'Virtual' ? 'selected' : '' }}>Virtual</option>
                            <option value="Híbrido" {{ old('formato') == 'Híbrido' ? 'selected' : '' }}>Híbrido</option>
                        </select>
                    </div>
                    <div class="ml-3">
                        <label for="docente_id">Docente</label>
                        <span class="text-danger">* Si no está registrado el docente, <a
                                href="{{ route('CrearDocente') }}">Haz clic aquí</a></span>
                        <select name="docente_id" class="form-control w-auto">
                            @forelse ($docente as $docente)
                                <option value="{{ $docente->id }}"
                                    {{ old('docente_id') == $docente->id ? 'selected' : '' }}>
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
                    <div class="mr-8">
                        <label for="edad_id">Edad estudiantes. (rango aproximado)</label>
                        <select name="edad_id" class="form-control custom-width">
                            @foreach ($edad as $item)
                                <option value="{{ $item->id }}" {{ old('edad_id') == $item->id ? 'selected' : '' }}>
                                    {{ ucfirst(strtolower($item->nombre)) }} {{ $item->edad1 }} entre
                                    {{ $item->edad2 }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="ml-3">
                        <label for="nivel_id">Niveles</label>
                        <select name="nivel_id" class="form-control custom-width">
                            @foreach ($niveles as $nivel)
                                <option value="{{ $nivel->id }}" {{ old('nivel_id') == $nivel->id ? 'selected' : '' }}>
                                    {{ ucfirst(strtolower($nivel->nombre)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Horarios dinámicos -->
                
                <br>
                <input class="btn btn-success" type="submit" value="Guardar">
            </div>
        </form>




    </div>
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
