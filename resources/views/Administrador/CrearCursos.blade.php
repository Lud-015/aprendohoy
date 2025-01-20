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
                <div class="form-group">
                    <label for="nombre">Nombre Curso</label>
                    <ul class="text-danger">
                        <li>El campo es obligatorio.</li>
                    </ul>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control custom-width">
                </div>


                <div class="form-group">
                    <label for="descripcion">Descripción Curso (Opcional)</label>
                    <input type="text" name="descripcion" value="{{ old('descripcion') }}"
                        class="form-control bv -ml-3">
                </div>

                <div style="display: flex; align-items: center;" class="mb-4">
                    <div class="mr-8" <label for="fecha_ini">Fecha Inicio</label><span class="text-danger">*</span>
                        <br>
                        <input type="date" name="fecha_ini" value="{{ old('fecha_ini') }}" class="form-control ">
                    </div>
                    <div class="ml-3">

                        <label for="fecha_fin">Fecha Fin</label><span class="text-danger">*</span>
                        <br>
                        <input type="date" name="fecha_fin" value="{{ old('fecha_fin') }}" class="form-control ">
                    </div>
                </div>

                <div style="display: flex; align-items: center;" class="mb-4">
                    <div class="mr-8">

                    <label for="formato">Formato</label>
                    <select name="formato" class="form-control w-auto">
                        <option value="Presencial" {{ old('formato') == 'Presencial' ? 'selected' : '' }}>Presencial
                        </option>
                        <option value="Virtual" {{ old('formato') == 'Virtual' ? 'selected' : '' }}>Virtual</option>
                        <option value="Híbrido" {{ old('formato') == 'Hibrido' ? 'selected' : '' }}>Híbrido</option>
                    </select>
                    </div>

                    <div class="ml-3">
                        <label for="docente_id">Docente</label>
                        <span class="text-danger">
                            * Si no esta registrado el docente,<a href="{{route('CrearDocente')}}"> Haz clic aqui</a>
                        </span>
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


                <div style="display: flex; align-items: center;" class="mb-4">

                <div class="mr-8">
                    <label for="edad_id">Edad estudiantes. (rango aproximado)</label>
                    <select name="edad_id" class="form-control custom-width">
                        @foreach ($edad as $item)
                            <option value="{{ $item->id }}" {{ old('edad_id') == $item->id ? 'selected' : '' }}>
                                {{ ucfirst(strtolower($item->nombre)) }} {{ $item->edad1 }} entre {{ $item->edad2 }}
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
                <br>
                <label for="">Horario</label>
                <ul class="text-danger">
                    <li>El campo es obligatorio. (Debe elegir al menos un día, posteriormente podrá editarlo)</li>
                </ul>
                <br>

                <input type="checkbox" name="Dias[]" value="Domingo"
                    {{ in_array('Domingo', old('Dias', [])) ? 'checked' : '' }}> Domingo
                <input type="checkbox" name="Dias[]" value="Lunes"
                    {{ in_array('Lunes', old('Dias', [])) ? 'checked' : '' }}> Lunes
                <input type="checkbox" name="Dias[]" value="Martes"
                    {{ in_array('Martes', old('Dias', [])) ? 'checked' : '' }}> Martes
                <input type="checkbox" name="Dias[]" value="Miércoles"
                    {{ in_array('Miércoles', old('Dias', [])) ? 'checked' : '' }}> Miércoles
                <input type="checkbox" name="Dias[]" value="Jueves"
                    {{ in_array('Jueves', old('Dias', [])) ? 'checked' : '' }}> Jueves
                <input type="checkbox" name="Dias[]" value="Viernes"
                    {{ in_array('Viernes', old('Dias', [])) ? 'checked' : '' }}> Viernes
                <input type="checkbox" name="Dias[]" value="Sabado"
                    {{ in_array('Sabado', old('Dias', [])) ? 'checked' : '' }}> Sábado


                <br><br>
                <ul class="text-danger">
                    <li>Los campos son obligatorios.</li>
                </ul>
                <div class="row col-11">
                    <label for="">Desde </label>
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    <input type="time" id="hora" name="hora1" value="{{ old('hora1') }}">
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    <label class="" for="">Hasta</label>
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    <input type="time" id="hora2" name="hora2" value="{{ old('hora2') }}">


                </div>




                <br>
                <br>
                <input class="btn  btn-success" type="submit" value="Guardar">


        </form>



    </div>
    </div>


    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <h2 class="bg-danger alert-danger">{{ $error }}</h2>
        @endforeach
    @endif
@endsection


@include('layout')
