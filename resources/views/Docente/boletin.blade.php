<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleta de Calificaciones</title>
    <style>
        /* Estilos CSS aquí */
        body {
            background-color: #e8e8e8;
            color: #000;
            /* Cambié el color del texto a negro */
            font-family: 'AB', sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .header-main {
            background: linear-gradient(to right bottom, #1A4789 49.5%, #FFFF 50%);
            height: 100%;
            /* Altura del 100% para ocupar todo el alto de la página */
            width: 55%;
            border: none;
            border-radius: 0;
            position: relative;
            overflow: hidden;
            margin: 0 auto;
            /* Esto centra horizontalmente el elemento en la página */
            border-radius: 10px;
        }

        /* Estilo para el contenedor de la navbar */
        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100%;
            width: 100%;
        }

        /* Estilo para los elementos de la navbar */
        .header-brand {
            height: 100%;
            width: auto;
            display: flex;
            align-items: center;
        }

        @font-face {
            font-family: AB;
            src: url(resources/fonts/AB.ttf);
        }

        h1 {
            font-family: 'AB', sans-serif;
            font-size: 20px;
            margin-left: 20px;
        }

        input {
            margin: 0% border: 0;
        }

        .container {
            max-width: 50%;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
        }

        .two-column-container {
            display: flex;
            justify-content: space-between;
        }

        .table-container {
            margin-top: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #63becf;
            color: #fff;
        }

        .diagnostic-input {
            width: 70%;
        }

        .nota-input {
            width: 30%;
        }

        .comentarios-input {
            width: 100%;
        }

        .firma-container {
            margin-top: 20px;
        }
        .custom-btn {
        background-color: #63becf;
        color: white;
        border: 1px solid #63becf;
        border-radius: 5px;
        margin: 10px; /* Puedes ajustar el valor según tus preferencias */
        box-shadow: 0 0 10px #1a4789;
    }
    </style>
</head>

<body>
<div class="border p-3">
    <a href="javascript:history.back()" class="btn btn-primary" style="background-color: #63becf; color: white; border: 1px solid #63becf;">
        &#9668; Volver
    </a>
    <br>
    <br>
</div>

    <header id="header-main" class="header header-main header-expand-lg header-transparent header-light py-10">
        <div class="header-container">
            <a class="header-brand logo-izquierdo" href="{{ route('Inicio') }}">
                <img src="{{ asset('resources/img/logof.png') }}" style="width: auto; height: 80px;">
            </a>
            <a class="header-brand logo-derecho" href="{{ route('Inicio') }}">
                <img src="{{ asset('resources/img/logoedin.png') }}" style="width: auto; height: 125px;">
            </a>
        </div>
    </header>

    <div class="titulo-main">
        <h1>BOLETA DE CALIFICACIONES</h1>
    </div>
    <form action="{{route('boletinPost', $inscritos->id)}}" method="POST">
    @csrf
    <div class="container">
        <div class="two-column-container">
            <div>
                <input type="text" name="estudiante" value="{{ $inscritos->id }}" hidden>
                <p>Estudiante:  {{ $inscritos->estudiantes->name }} {{ $inscritos->estudiantes->lastname1 }} {{ $inscritos->estudiantes->lastname2 }}
                <p>Docente: {{ $inscritos->cursos->docente->name }} {{ $inscritos->cursos->docente->lastname1 }}
                    {{ $inscritos->cursos->docente->lastname2 }}</p>
                <p>Periodo: {{ $inscritos->cursos->fecha_ini }} al {{ $inscritos->cursos->fecha_fin }}</p>
            </div>
            <div>
                <p>Curso: {{ $inscritos->cursos->nombreCurso }}</p>
                <p>Nivel: {{ $inscritos->cursos->nivel->nombre }}</p>

            </div>
        </div>
        <div class="table-container">
            <table id="miTabla">
                <tr>
                    <th>Diagnóstico</th>
                    <th>Nota</th>
                </tr>

                <tr>
                <td>EVALUACIONES</td>
                <td>
                    @if($promedioNotasEvaluacion > 0)
                    <input class="form-control" type="text" name="evaluaciones" value="evaluaciones{{ $inscritos->estudiantes->name }} {{ $inscritos->estudiantes->lastname1 }} {{ $inscritos->estudiantes->lastname2 }}" hidden>
                    <input class="form-control" type="text" name="notaEvaluacion" value="{{round($promedioNotasEvaluacion)}}" hidden>
                    <p>
                        {{round($promedioNotasEvaluacion)}}
                    </p>
                    @else
                    <p>No se encontraron notas para este estudiante.</p>
                    @endif</td>
                </tr>
                <tr>
                <td>TAREAS</td>
                    <td>
                        @if($promedioNotasTareas > 0)
                        <input class="form-control" type="text" name="tareas" value="tareas {{ $inscritos->estudiantes->name }} {{ $inscritos->estudiantes->lastname1 }} {{ $inscritos->estudiantes->lastname2 }}" hidden>
                        <input class="form-control" type="text" name="notaTarea" value="{{round($promedioNotasTareas)}}" hidden>
                        <p>
                            {{round($promedioNotasTareas)}}
                        </p>
                        @else
                        <p>No se encontraron notas para este estudiante.</p>
                        @endif
                    </td>

                </tr>


            </table>
            <table>
                <tr>
                    <td>CALIFICACIÓN FINAL</td>
                    <td>
                        <p>{{round(($promedioNotasTareas+$promedioNotasEvaluacion)/2)}}</p>
                        <input type="text" name="notafinal" value="{{round(($promedioNotasTareas+$promedioNotasEvaluacion)/2)}}" hidden>
                    </td>
                </tr>
            </table>
            <p>Comentarios y recomendaciones del docente:</p>
            <textarea class="comentarios-input" name="comentario" value="{{old('comentario')}}" rows="4" required></textarea>
        </div>
        <div class="firma-container">
            <p>DIRECCIÓN EJECUTIVA: FUNDACIÓN EDUCAR PARA LA VIDA</p>
        </div>
        <br><br>
        <input type="submit" value="GUARDAR">
    </div>
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

</body>






</html>
