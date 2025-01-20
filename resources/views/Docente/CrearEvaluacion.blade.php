


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
                <a class="nav-link" href="{{ route('AsignarCurso') }}">
                    <i class="ni ni-key-25 text-info"></i> Asignación de Cursos
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
                <a class="nav-link" href="{{ route('AsignarCurso') }}">
                    <i class="ni ni-key-25 text-info"></i> Asignación de Cursos
                </a>
            </li>

        </ul>
    @endif


@endsection

@section('content')

<div class="border p-3">
<a href="javascript:history.back()" class="btn btn-primary">
    &#9668; Volver
</a>
<br>
<div class="tareadocente-container">
    <div class="title">
        <h2>Creación de Evaluación</h2>
        <p>Curso: Curso de {{$cursos->nombreCurso}}</p> <!-- Reemplaza "Curso de Ejemplo" con el nombre real del curso -->
    </div>

    <div class="task-form">
        <form method="POST" action="{{route('CrearEvaluacionPost',$cursos->id)}}" enctype="multipart/form-data">
            @csrf
            <input type="text" name="cursos_id" value="{{$cursos->id}}"  hidden>
            <div class="form-group">
                <label for="taskTitle">Título de la Evaluación:</label>
                <input type="text" id="taskTitle" name="tituloEvaluacion" value="{{old('tituloEvaluacion')}}" required>
            </div>
            <div class="form-group">
                <label for="taskDescription">Descripción de la Evaluación:</label>
                <textarea id="taskDescription" name="evaluacionDescripcion" value="{{old('evaluacionDescripcion')}}"  rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="dueDate">Fecha de habilitación:</label>
                <input type="date" id="dueDate" name="fechaHabilitacion"  value="{{old('fechaHabilitacion')}}" required>
            </div>
            <div class="form-group">
                <label for="dueDate">Fecha de Vencimiento:</label>
                <input type="date" id="dueDate" name="fechaVencimiento" value="{{old('fechaVencimiento')}}" required>
            </div>
            <div class="form-group">
                <label for="points">Puntos de calificación:</label>
                <input type="number" id="points" name="puntos" value="{{old('puntos')}}" required>
            </div>
            <div class="form-group">
                <label for="fileUpload">Adjuntar Archivo:</label>
                <input type="file" id="fileUpload" name="evaluacionArchivo" value="{{old('evaluacionArchivo')}}">
            </div>

            <button class="btn btn-success" type="submit">Guardar</button>
        </form>
    </div>

<style>
        .tareadocente-container {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin: 20px;
        }

        .title {
            text-align: left;
        }

        .task-form {
            width: 100%;
            max-width: 400px;
            text-align: left;
            margin-top: 20px;
        }

    .task-form h2 {
        margin-bottom: 20px;
        font-size: 24px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    input[type="text"],
    textarea,
    input[type="date"],
    input[type="number"],
    input[type="file"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    input[type="checkbox"] {
        margin-top: 5px;
    }

    button {
        background-color: #007BFF;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 18px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }
</style>


</div>

@if ($errors->any())
@foreach ($errors->all() as $error)
    <h2 class="bg-danger alert-danger">{{$error}}</h2>
@endforeach
@endif

@endsection

@include('layout')

