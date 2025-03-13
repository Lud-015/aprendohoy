@section('titulo')
Editar Evaluacion
@endsection




@section('content')
<div class="border p-3">
<a href="javascript:history.back()" class="btn btn-primary">
    &#9668; Volver
</a>
<br>

<div class="tareadocente-container">
    <div class="title">
        <h2>Editar Evaluacion</h2>
    </div>

    <div class="task-form">
        <form method="POST" enctype="multipart/form-data" action="{{route('editarEvaluacionPost', $evaluacion->id)}}">
            @csrf
            <input type="text" name="cursos_id" value="{{$evaluacion->cursos_id}}"  hidden>
            <input type="text" name="idEvaluacion" value="{{$evaluacion->id}}"  hidden>
            <div class="form-group">
                <label for="taskTitle">Título de la Evaluacion:</label>
                <input type="text" id="taskTitle" name="tituloEvaluacion" value="{{$evaluacion->titulo_evaluacion}}" required>
            </div>
            <div class="form-group">
                <label for="taskDescription">Descripción de la Evaluacion:</label>
                <textarea id="taskDescription" name="evaluacionDescripcion" rows="4" required>{{$evaluacion->descripcionEvaluacion}}</textarea>
            </div>
            <div class="form-group">
                <label for="dueDate">Fecha de habilitación:</label>
                <input type="date" id="dueDate" name="fechaHabilitacion" value="{{$evaluacion->fecha_habilitacion}}" required>
            </div>
            <div class="form-group">
                <label for="dueDate">Fecha de Vencimiento:</label>
                <input type="date" id="dueDate" name="fechaVencimiento" value="{{$evaluacion->fecha_vencimiento}}" required>
            </div>
            <div class="form-group">
                <label for="points">Puntos de calificacion:</label>
                <input type="number" id="points" name="puntos" value="{{$evaluacion->puntos}}" required>
            </div>
            <div class="form-group">
                <label for="fileUpload">Adjuntar Archivo:</label>
                <input type="file" id="fileUpload" name="tareaArchivo">
            </div>

            <button type="submit">Guardar Cambios</button>
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

