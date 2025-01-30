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
    </style>

</head>

<body>
<div class="border p-3">
<div class="border p-3">
        <div class="button-container">
            <a href="javascript:history.back()" class="btn btn-primary custom-btn">
                &#9668; Volver<br>
            </a>

            <a href="#" class="btn btn-primary custom-btn" id="generatePdfLink">Generar PDF</a>
        </div>
        <br>
        <br>
    </div>

<div class="container" id="container">
    <header id="header-main" class="header header-main header-expand-lg header-transparent header-light py-10">
        <div class="header-container">
            <a class="header-brand logo-izquierdo" href="../index.html">
                <img src="{{asset('assets/img/logof.png')}}" style="width: auto; height: 80px;">
            </a>
            <a class="header-brand logo-derecho" href="../index.html">
                <img src="{{asset('assets/img/Acceder.png')}}" style="width: auto; height: 125px;">
            </a>
        </div>
    </header>
    <div class="titulo-main">
        <h1>Lista de Estudiantes</h1>
    </div>
    <div class="two-column-container">
        <div>
            <p>Estudiante: {{auth()->user()->name}} {{auth()->user()->lastname1}} {{auth()->user()->lastname2}}</p>
            <p>Docente: {{$curso->docente->name}} {{$curso->docente->lastname1}} {{$curso->docente->lastname2}}
            <p>Periodo: {{ $curso->fecha_ini }} al {{ $curso->fecha_fin }}</p>
        </div>
        <div>
            <p>Curso: {{ ucfirst(strtolower($curso->nombreCurso))}}</p>
            <p>Nivel: {{ ucfirst(strtolower($curso->nivel)) }}</p>
            <p>Horario: @foreach ($horarios as $horarios)
                {{$horarios->horario->dia}}
                {{Carbon\Carbon::parse($horarios->horario->hora_inicio)->format('h:i A') }} a
                {{Carbon\Carbon::parse($horarios->horario->hora_fin)->format('h:i A') }}
                <br>
            @endforeach
        </div>
    </div>
    <div class="table-container">
        <table>
            <tr>
                <th>Nro</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
            </tr>
            @forelse ($inscritos as $inscritos)
            @if ($inscritos->cursos_id == $curso->id)
            <tr>

                <td scope="row">

                    {{ $loop->iteration }}

                </td>
                <td scope="row">
                    {{ isset($inscritos->estudiantes) ? $inscritos->estudiantes->name : 'Estudiante Eliminado' }}
                </td>
                <td>

                    {{ isset($inscritos->estudiantes) ? $inscritos->estudiantes->lastname1 : '' }}
                </td>
                <td>

                    {{ isset($inscritos->estudiantes) ? $inscritos->estudiantes->lastname2 : '' }}
                </td>



            </tr>
            @endif


            @empty
            <tr>

                <td>

                    <h4>NO HAY ALUMNOS INSCRITOS</h4>

                </td>
            </tr>




            @endforelse

        </table>



        </p>

        <br><br><br>
        FUNDACIÓN EDUCAR PARA LA VIDA</p>
    </div>


</div>

<br><br>




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

</body>
</html>
