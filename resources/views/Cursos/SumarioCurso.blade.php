<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reporte Final </title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Estilos CSS aquí */
        body {
            background-color: #a1a3a7;
            color: #000; /* Cambié el color del texto a negro */
            font-family: 'AB', sans-serif;
            text-align: center;
            margin: 0; /* Asegúrate de que el margen del cuerpo sea 0 para evitar espacios innecesarios */
            padding: 0;
        }

        .header-main {
            background: linear-gradient(to right bottom, #1A4789 49.5%, #FFFF 50%);
            height: 100%; /* Altura del 100% para ocupar todo el alto de la página */
            width: 100%;
            border: none;
            border-radius: 0;
            position: relative;
            overflow: hidden;
            margin: 0 auto; /* Esto centra horizontalmente el elemento en la página */
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
            src: url({{asset('assets/fonts/AB.ttf')}});
        }

        h1 {
            font-family: 'AB', sans-serif;
            font-size: 20px;
            margin-left: 20px;
        }

        .container {
            max-width: 90%;
            margin: 15px;
            background-color: #ffffff;
            padding: 15px;
            border-radius: 5px;
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

        th, td {
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
            margin-top: 10px;
        }
         .firma {
            width: 70px;
            display: inline-block;
        }
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
        .chart-wrapper {
            display: flex;
            align-items: center;
        }
        #chart-container {
            margin: 0 10px;
        }
        canvas {
            background-color: #f3f3f3;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>

</head>

<body>
    @if (auth()->user()->hasRole('Administrador'))
 <a href="#" class="btn btn-primary custom-btn" id="generatePdfLink">Generar PDF</a>
    @endif


<div class="container" id="container">
    <header id="header-main" class="header header-main header-expand-lg header-transparent header-light py-10">
        <div class="header-container">
            <div class="header-brand logo-izquierdo" >
                <img src="{{asset('assets/img/logof.png')}}" style="width: auto; height: 80px;">
            </div>
            <div class="header-brand logo-derecho" >
                <img src="{{asset('assets/img/Acceder.png')}}" style="width: auto; height: 125px;">
            </div>
        </div>
    </header>
    <div class="titulo-main">
        <h1>SUMARIO DEL CURSO</h1>
    </div>
    <div class="two-column-container">
        <div>
            <p>Curso: {{$cursos->nombreCurso}}</p>
            <p>Docente: {{$cursos->docente->name}} {{$cursos->docente->lastname1}} {{$cursos->docente->lastname2}}
            <p>Periodo: {{ $cursos->fecha_ini }} al {{ $cursos->fecha_fin }}</p>
        </div>
        <div>
            <p>Nivel: {{ $cursos->nivel }}</p>
            <p>Horario:

            <p>Estudiantes Inscritos: {{$inscritos->count()}}</p>
        </div>
    </div>
    <h3>CONTENIDO</h3>
    <div class="two-column-container">
        <div style="margin-left: 100px ">
            <p>Temas: {{$temas->count()}}</p>
            <p>Subtemas:</p>
            <p>Tareas: </p>
            <p>Evaluaciones: {{$evaluaciones->count()}}</p>
            <p>Foros: {{ $foros->count() }}</p>
        </div>
        <div style="margin-right: 100px ">
            <p>Recursos: {{ $recursos->count() }}</p>
            <p>cuestionarios: </p>
            <p>Asistencias: {{$asistencias->count()}}</p>
        </div>
    </div>

    <style>
        #chart-container {
            width: 340px; /* Ancho deseado */
            height: 170px; /* Altura deseada */
        }
    </style>


    <h3>Participantes
    </h3>
    <div class="table-container">
        <table>
            <tr>
                <th>Estudiante</th>
                <th>Asistencias</th>
                <th>Asistencias</th>
                <th>Nota final</th>
                <th>Escala de calificación</th>
            </tr>

            @foreach ($inscritos as $inscritos)
            <tr>
                <td>{{$inscritos->estudiantes->name. ' '. $inscritos->estudiantes->lastname1. ' '. $inscritos->estudiantes->lastname2}}</td>
                <td>{{$inscritos->asistencia->count()}}</td>
                <td>

                    Presente: {{ $inscritos->asistencia->where('tipoAsitencia', 'Presente')->count() }}
                    <br>
                    Retraso: {{ $inscritos->asistencia->where('tipoAsitencia', 'Retraso')->count() }}
                    <br>
                    Falta: {{ $inscritos->asistencia->where('tipoAsitencia', 'Falta')->count() }}
                    <br>
                    Licencia: {{ $inscritos->asistencia->where('tipoAsitencia', 'Licencia')->count() }}
                    <br>
                </td>


                <td>{{($inscritos->notatarea->avg('nota') + $inscritos->notaevaluacion->avg('nota') )/2 }}</</td>


                <td>
                @if ((($inscritos->notatarea->avg('nota') + $inscritos->notaevaluacion->avg('nota') )/2) <= 51)
                Participante
                @elseif ((($inscritos->notatarea->avg('nota') + $inscritos->notaevaluacion->avg('nota') )/2) <= 65)
                Aprendiz
                @elseif ((($inscritos->notatarea->avg('nota') + $inscritos->notaevaluacion->avg('nota') )/2) <= 75)
                Habilidoso
                @elseif ((($inscritos->notatarea->avg('nota') + $inscritos->notaevaluacion->avg('nota') )/2) <= 100)
                Experto
                @endif
                </td>



            </tr>
            <tr>
            </tr>
            @endforeach

        </table>

        <br><br><br>
        <h3>Estadisticas del curso</h3>


        <div>
            <div style="display: flex; align-items: center;" class="mb-4">
            <div id="chart-container">
                <canvas id="myChart"></canvas>
            </div>
            <div id="chart-container">
                <canvas id="myChart2"></canvas>
            </div>

            </div>
            <br>


            <script>
                var ctx = document.getElementById('myChart2').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Participante', 'Aprendiz', 'Habilidoso', 'Experto'],
                        datasets: [{
                            label: 'Cantidad de Estudiantes',
                            data: [
                                {{ $participanteCount }},
                                {{ $aprendizCount }},
                                {{ $habilidosoCount }},
                                {{ $expertoCount }}
                            ],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>


            <script>
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Presente', 'Retraso', 'Falta', 'Licencia'],
                        datasets: [{
                            label: 'Asistencias',
                            data: [
                                {{ $conteoPresentes }},
                                {{ $conteoRetrasos }},
                                {{ $conteoFaltas }},
                                {{ $conteoLicencias }}
                            ],
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(75, 192, 192, 0.2)'
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(255, 99, 132, 1)',
                                'rgba(75, 192, 192, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>

        </div>


        </p>

        @if (auth()->user()->hasRole('Administrador'))

        <br><br><br>
        <img class="firma" src="{{asset('assets/img/firma digital.png')}}" alt="firma">
        <p class="">Mba. Roxana Araujo Romay</p>
        <p class="">Directora Ejecutiva</p>
        <p class="">DIRECCIÓN EJECUTIVA: FUNDACIÓN EDUCAR PARA LA VIDA</p>
        @endif

    </div>


</div>

<br><br>






</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.7.0/d3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.6.7/c3.min.js"></script>
<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<script>


    document.addEventListener('DOMContentLoaded', function () {
        // Función para generar el PDF
        function generatePdf() {
            var element = document.getElementById('container');

            html2pdf(element, {
                filename: 'listadeEstudiantes.pdf',

            }).then(function(pdf) {
                console.log('PDF generado correctamente:', pdf);
            }).catch(function(error) {
                console.error('Error al generar el PDF:', error);
            });
        }

        // Obtén el enlace por su ID
        var generatePdfLink = document.getElementById('generatePdfLink');

        // Agrega un evento de clic al enlace que llame a la función generatePdf
        generatePdfLink.addEventListener('click', function (event) {
            event.preventDefault(); // Evita el comportamiento predeterminado del enlace
            generatePdf();
        });
    });

        //  document.addEventListener('DOMContentLoaded', function () {
        //     var element = document.getElementById('container');

        //     html2pdf(element, {
        //         filename: 'boletin.pdf',
        //         margin: 12, // Establece márgenes iguales en todos los lados (en milímetros)
        //         image: { type: 'jpeg', quality: 0.98 } // Opcional: Mejora la calidad de las imágenes en el PDF
        //     }).then(function(pdf) {
        //         console.log('PDF generado correctamente:', pdf);
        //     }).catch(function(error) {
        //         console.error('Error al generar el PDF:', error);
        //     });
        // });
    </script>



</html>
