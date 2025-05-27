<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleta de Calificaciones</title>

    <style>
        .border {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .custom-btn {
            background-color: #63becf;
            color: white;
            border: 1px solid #63becf;
            border-radius: 5px;
            padding: 10px 20px;
            margin: 10px;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
        }

        .button-container {
            text-align: center;
        }

        .container {
            max-width: 90%;
            margin: 15px;
            background-color: #ffffff;
            padding: 15px;
            border-radius: 5px;
        }

        body {
            background-color: #a1a3a7;
            color: #000;
            font-family: 'AB', sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .header-main {
            background: linear-gradient(to right bottom, #1A4789 49.5%, #FFFF 50%);
            height: 100%;
            width: 100%;
            border: none;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
            margin: 0 auto;
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100%;
            width: 100%;
        }

        .header-brand {
            height: 100%;
            width: auto;
            display: flex;
            align-items: center;
        }

        @font-face {
            font-family: AB;
            src: url({{asset('assets/fonts/AB.ttf')}});
        }

        h1 {
            font-family: 'AB', sans-serif;
            font-size: 20px;
            margin-left: 20px;
        }

        .table-container {
            margin-top: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #63becf;
            color: #fff;
        }

        .resumen-container {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .estado {
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 3px;
            display: inline-block;
        }

        .estado-experto { background-color: #28a745; color: white; }
        .estado-habilidoso { background-color: #17a2b8; color: white; }
        .estado-aprendiz { background-color: #ffc107; color: black; }
        .estado-reprobado { background-color: #dc3545; color: white; }

        .firma-container {
            margin-top: 40px;
            text-align: center;
        }

        .firma {
            width: 150px;
            margin-bottom: 10px;
        }

        .firma-texto {
            margin: 5px 0;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="border p-3">
        <div class="border p-3">
            <div class="button-container">
                <a href="javascript:history.back()" class="btn btn-primary custom-btn">
                    &#9668; Volver
                </a>
                <a class="btn btn-primary custom-btn" id="generatePdfLink">Generar PDF</a>
            </div>
        </div>

        <div class="container" id="container">
            <header id="header-main" class="header header-main header-expand-lg header-transparent header-light py-10">
                <div class="header-container">
                    <a class="header-brand logo-izquierdo">
                        <img src="{{asset('assets/img/logof.png')}}" style="width: auto; height: 80px;">
                    </a>
                    <a class="header-brand logo-derecho">
                        <img src="{{asset('assets/img/logoedin.png')}}" style="width: auto; height: 125px;">
                    </a>
                </div>
            </header>

            <div class="titulo-main">
                <h1>BOLETA DE CALIFICACIONES</h1>
            </div>

            <div class="info-container">
                <p><strong>Estudiante:</strong> {{$inscritos->estudiantes->name}} {{$inscritos->estudiantes->lastname1}} {{$inscritos->estudiantes->lastname2}}</p>
                <p><strong>Curso:</strong> {{$inscritos->cursos->nombreCurso}}</p>
                <p><strong>Docente:</strong> {{$inscritos->cursos->docente->name}} {{$inscritos->cursos->docente->lastname1}} {{$inscritos->cursos->docente->lastname2}}</p>
                <p><strong>Periodo:</strong> {{$inscritos->cursos->fecha_ini}} al {{$inscritos->cursos->fecha_fin}}</p>
                <p><strong>Nivel:</strong> {{$inscritos->cursos->nivel}}</p>
                {{-- <p><strong>Horario:</strong>
                    @foreach(json_decode($inscritos->cursos->horarios->dias) as $dia)
                        {{$dia}},
                    @endforeach
                    De {{$inscritos->cursos->horarios->hora_ini}} a {{$inscritos->cursos->horarios->hora_fin}}
                </p> --}}
            </div>

            <div class="resumen-container">
                <h2>Resumen de Calificaciones</h2>
                <p><strong>Promedio de Actividades (70%):</strong> {{$resumen['promedio_actividades']}}</p>
                <p><strong>Porcentaje de Asistencia (30%):</strong> {{$resumen['porcentaje_asistencia']}}</p>
                <p><strong>Nota Final:</strong> {{$resumen['nota_final']}}</p>
                <p><strong>Estado:</strong>
                    <span class="estado estado-{{strtolower($resumen['estado'])}}">
                        {{$resumen['estado']}}
                    </span>
                </p>
            </div>

            <div class="table-container">
                <h2>Detalle de Actividades</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Tema</th>
                            <th>Subtema</th>
                            <th>Actividad</th>
                            <th>Tipo</th>
                            <th>Nota</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($actividadesData as $actividad)
                        <tr>
                            <td>{{$actividad['tema']}}</td>
                            <td>{{$actividad['subtema']}}</td>
                            <td>{{$actividad['actividad']}}</td>
                            <td>{{$actividad['tipo']}}</td>
                            <td>{{$actividad['nota']}}</td>
                            <td>{{$actividad['estado']}}</td>
                            <td>{{$actividad['fecha']}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if(isset($boletin))
            <div class="comentarios-container">
                <h2>Comentarios del Docente</h2>
                <p>{{$boletin->comentario_boletin ?? 'Sin comentarios'}}</p>
            </div>
            @endif

            <div class="firma-container">
                <img class="firma" src="{{asset('assets/img/firma digital.png')}}" alt="firma">
                <p class="firma-texto">Mba. Roxana Araujo Romay</p>
                <p class="firma-texto">Directora Ejecutiva</p>
                <p class="firma-texto">DIRECCIÓN EJECUTIVA: FUNDACIÓN EDUCAR PARA LA VIDA</p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('generatePdfLink').addEventListener('click', function() {
            window.print();
        });
    </script>
</body>
</html>
