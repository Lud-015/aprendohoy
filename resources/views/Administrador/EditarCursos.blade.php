
@section('titulo')
Crear Curso
@endsection


@section('nav')
    @if (auth()->user()->hasRole('Administrador'))
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
                <a class="nav-link " href="./examples/tables.html">
                    <i class="ni ni-bullet-list-67 text-red"></i> Aportes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('AsignarCurso') }}">
                    <i class="ni ni-key-25 text-info"></i> Asignar Cursos
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
                    <i class="ni ni-key-25 text-info"></i> Asignar Cursos
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
<form  class="form ml-3 col-10" action="" method="POST">

    @csrf
    <label  el for="">Nombre Curso</label>
    <input type="text" value="{{$cursos->nombreCurso}}" name="nombre"><br>
    <label for="">Descripcion Curso</label>
    <input type="text" value="{{$cursos->descripcionC}}" name="descripcion"><br>
    <label for="">Fecha Inicio</label>
    <input type="date" value="{{$cursos->fecha_fin}}"  name="fecha_ini"><br>
    <label for="">Fecha Fin</label>
    <input type="date" value="{{$cursos->fecha_fin}}" name="fecha_fin"><br>
    <label for="">Formato</label>
    <select name="formato" id="">
       <option value="Presencial">Presencial</option>
       <option value="Virtual">Virtual</option>
       <option value="Hibrido">Hibrido</option>
    </select>
    <br>
    <label for="">Docente</label>
    <select name="docente_id" id="">
       @foreach ($docente as $docente)
           <option    @selected($cursos->docente_id == $docente->id )
            @class([ 'bg-purple-600 text-white' => $cursos->docente_id == $docente->id])
            value="{{$docente->id }}">{{$docente->name}}  {{$docente->lastname1}} {{$docente->lastname2}}</option>
       @endforeach
    </select>
    <br>
    <label for="">Edad Dirigida</label>
    <select name="edad_id" id="">
       @foreach ($edad as $edad)
           <option value="{{$edad->id }}">{{$edad->nombre}}  {{$edad->edad1}}  ENTRE  {{$edad->edad2}}</option>
           @endforeach
    </select>
    <br>
    <label for="">Niveles</label>

    <select name="nivel_id" id="">
       @foreach ($niveles as $niveles)
           <option value="{{$niveles->id }}">{{$niveles->nombre}}  </option>
       @endforeach
    </select>

    <br>
    <label for="">Horarios</label>
    <select name="horario_id" id="">
       @foreach ($horario as $horario)
           <option value="{{$horario->id }}">{{$horario->dias}} de {{$horario->hora_ini}} a {{$horario->hora_fin}}  </option>
       @endforeach
    </select>
    <br>
    <br>
    <input type="submit" value="Editar Curso">


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

@endsection


@include('layout')
