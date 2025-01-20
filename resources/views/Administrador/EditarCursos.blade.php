
@section('titulo')
Editar Curso
@endsection


@section('nav')
    @if (auth()->user()->hasRole('Administrador'))
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Miperfil') }}">
                    <i class="ni ni-circle-08 text-green"></i> Mi perfil
                </a>
            </li>
            <li class="nav-item   ">
                <a class="nav-link   " href="{{ route('Inicio') }}">
                    <i class="ni ni-tv-2 text-primary"></i> Inicio
                </a>
            </li>
            <li class="nav-item   ">
                <a class="nav-link  " href="{{ route('ListadeCursos') }}">
                    <i class="ni ni-book-bookmark text-blue"></i> Lista de Cursos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{ route('ListaDocentes') }}">
                    <i class="ni ni-single-02 text-blue"></i> Lista de Docentes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{ route('ListaEstudiantes') }}">
                    <i class="ni ni-single-02 text-orange"></i> Lista de Estudiantes
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link " href="{{ route('aportesLista') }}">
                    <i class="ni ni-bullet-list-67 text-red"></i> Aportes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('AsignarCurso') }}">
                    <i class="ni ni-key-25 text-info"></i> Asignación Cursos
                </a>
            </li>

        </ul>
    @endif

    @if (auth()->user()->hasRole('Docente'))
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Miperfil') }}">
                    <i class="ni ni-circle-08 text-green"></i> Mi perfil
                </a>
            </li>
            <li class="nav-item  active ">
                <a class="nav-link  active " href="{{ route('Inicio') }}">
                    <i class="ni ni-tv-2 text-primary"></i> Mis Cursos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="./examples/tables.html">
                    <i class="ni ni-bullet-list-67 text-red"></i> Aportes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('AsignarCurso') }}">
                    <i class="ni ni-key-25 text-info"></i> Asignación Cursos
                </a>
            </li>

        </ul>
    @endif

    @if (auth()->user()->hasRole('Estudiante'))
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Miperfil') }}">
                    <i class="ni ni-circle-08 text-green"></i> Mi perfil
                </a>
            </li>
            <li class="nav-item  active ">
                <a class="nav-link  active " href="{{ route('Inicio') }}">
                    <i class="ni ni-tv-2 text-primary"></i> Mis Cursos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="./examples/tables.html">
                    <i class="ni ni-bullet-list-67 text-red"></i> Mis Aportes
                </a>
            </li>


        </ul>
    @endif
@endsection



@section('content')
<div class="col-xl-12">
    <a href="javascript:history.back()" class="btn btn-sm btn-primary">
    &#9668; Volver
</a>
<a href="{{route('crearNivel')}}" class="btn btn-sm btn-success">
    Añadir Nivel
</a>
<a href="{{route('crearEdad')}}" class="btn  btn-sm btn-success">
    Añadir rango de edad
</a>

<br>
<br>
<div class="border p-3 mb-3 col-xl-12">
    <form class="form ml-3 col-10" action="{{route('editarCursoPost', $cursos->id)}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="nombre">Nombre Curso</label>
            <input type="text" value="{{$cursos->nombreCurso}}" name="nombre" class="form-control custom-input">
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción Curso</label>
            <input type="text" value="{{$cursos->descripcionC}}" name="descripcion" class="form-control custom-input">
        </div>

        <div style="display: flex; align-items: center;" class="mb-4">

        <div class="mr-8">
            <label @if (auth()->user()->hasRole('Docente'))
                disable hidden
                @endif   for="fecha_ini">Fecha Inicio</label>
            <input @if (auth()->user()->hasRole('Docente'))
            disable hidden
            @endif type="date" value="{{$cursos->fecha_ini}}" name="fecha_ini" class="form-control w-auto">
        </div>

        <div class="ml-3">
            <label  for="fecha_fin"
            @if (auth()->user()->hasRole('Docente'))
            disable hidden
            @endif

            >Fecha Fin</label>
            <input type="date" value="{{$cursos->fecha_fin}}" name="fecha_fin" class="form-control w-auto"
            @if (auth()->user()->hasRole('Docente'))
            disable hidden
            @endif>
        </div>
        </div>
        <div style="display: flex; align-items: center;" class="mb-4">

        <div class="mr-3">
            <label for="fecha_fin">Nota Aprobación(Por defecto 51.)</label>
            <input type="number" value="{{$cursos->notaAprobacion ?? ''}}" name="nota" class="form-control custom-input">
        </div>
        @if (auth()->user()->hasRole('Docente'))

        <div class="ml-3">
            <label for="fecha_fin">Tabla de Contenidos</label>
            <br>
            <input type="file" value="{{$cursos->archivoContenidodelCurso ?? ''}}" name="archivo" class="form-control custom-input">

        </div>

        @if($cursos->archivoContenidodelCurso == '' )

        <div class="">

        <span>No se ha cargado ningún archivo todavía</span>
        </div>

        @else

            <div>
                Archivo actual: <br>
                <embed src="{{ asset('storage/' . $cursos->archivoContenidodelCurso) }}" type="application/pdf" width="100%" height="250px" />
            </div>

        @endif
        @endif

        </div>


        <div style="display: flex; align-items: center;" class="mb-4">

            <div class="mr-8">
                <label for="formato">Formato</label>
                <select name="formato" id="formato" class="form-control w-auto">
                    <option value="Presencial" {{ $cursos->formato === 'Presencial' ? 'selected' : '' }}>Presencial</option>
                    <option value="Virtual" {{ $cursos->formato === 'Virtual' ? 'selected' : '' }}>Virtual</option>
                    <option value="Híbrido" {{ $cursos->formato === 'Híbrido' ? 'selected' : '' }}>Híbrido</option>
                </select>
            </div>

        @if (auth()->user()->hasRole('Docente'))
            <input type="text" value="{{auth()->user()->id}}" name="docente_id" hidden readonly>
        @endif

        @if (auth()->user()->hasRole('Administrador'))
            <div class="ml-3">
                <label for="docente_id">Docente</label>
                <select name="docente_id" id="" class="form-control w-auto">
                    @foreach ($docente as $docente)
                        <option @selected($cursos->docente_id == $docente->id) @class(['bg-purple-600 text-white' => $cursos->docente_id == $docente->id]) value="{{$docente->id }}">{{$docente->name}}  {{$docente->lastname1}} {{$docente->lastname2}}</option>
                    @endforeach
                </select>
            </div>
        @endif
        </div>


        <div style="display: flex; align-items: center;" class="mb-4">


        <div class="mr-8">
            <label for="edad_id">Edad Dirigida</label>
            <select name="edad_id" id="" class="form-control w-auto">
                @foreach ($edad as $edad)
                    <option value="{{$edad->id }}"  {{ $cursos->edadDir_id === $edad->id ? 'selected' : '' }}>{{ ucfirst(strtolower($edad->nombre))}}  {{$edad->edad1}}  ENTRE  {{$edad->edad2}}</option>
                @endforeach
            </select>
        </div>

        <div class="ml-3">
            <label for="nivel_id">Niveles</label>
            <select name="nivel_id" id="" class="form-control w-auto">
                @foreach ($niveles as $niveles)
                    <option value="{{$niveles->id }}" {{ $cursos->niveles_id === $niveles->id ? 'selected' : '' }}>{{ ucfirst(strtolower($niveles->nombre))}}  </option>
                @endforeach
            </select>
        </div>
        </div>

        <style>
            .custom-input {
                width: 50%;
                height: 50px;
            }
        </style>

    <label for="">Horario</label>
    <br>
    <input type="text" name="horario_id" value="{{$cursos->horario_id}}" hidden>


    <label>
        <input type="checkbox" name="Dias[]" value="Domingo" {{ in_array('Domingo', json_decode($cursos->horarios->dias)) ? 'checked' : '' }}> Domingo
    </label>
    <label>
        <input type="checkbox" name="Dias[]" value="Lunes" {{ in_array('Lunes', json_decode($cursos->horarios->dias)) ? 'checked' : '' }}> Lunes
    </label>
    <label>
        <input type="checkbox" name="Dias[]" value="Martes" {{ in_array('Martes', json_decode($cursos->horarios->dias)) ? 'checked' : '' }}> Martes
    </label>
    <label>
        <input type="checkbox" name="Dias[]" value="Miércoles" {{ in_array('Miércoles', json_decode($cursos->horarios->dias)) ? 'checked' : '' }}> Miércoles
    </label>
    <label>
        <input type="checkbox" name="Dias[]" value="Jueves" {{ in_array('Jueves', json_decode($cursos->horarios->dias)) ? 'checked' : '' }}> Jueves
    </label>
    <label>
        <input type="checkbox" name="Dias[]" value="Viernes" {{ in_array('Viernes', json_decode($cursos->horarios->dias)) ? 'checked' : '' }}> Viernes
    </label>
    <label>
        <input type="checkbox" name="Dias[]" value="Sabado" {{ in_array('Sabado', json_decode($cursos->horarios->dias)) ? 'checked' : '' }}> Sabado
    </label>


    <br><br>
    <div class="row col-11">
        <label for="">Desde </label>
        &nbsp;
        &nbsp;
        &nbsp;
        &nbsp;
        <input type="time" id="hora" name="hora1" value="{{$cursos->horarios->hora_ini}}">
        &nbsp;
        &nbsp;
        &nbsp;
        &nbsp;
        <label class="" for="">Hasta</label>
        &nbsp;
        &nbsp;
        &nbsp;
        &nbsp;
        <input type="time" id="hora2" name="hora2" value="{{$cursos->horarios->hora_fin}}">


    <!-- Button trigger modal -->
</div>

<br>
<input class="btn btn btn-success" type="submit" value="Guardar Cambios">
<br>
<br>



 </form>

 @if ($errors->any())
 <div class="alert alert-danger">
     <ul>
         @foreach ($errors->all() as $error)
             <li>{{ $error }}</li>
         @endforeach
     </ul>
 </div>
@endif


@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
</div>
@endsection


@include('layout')
