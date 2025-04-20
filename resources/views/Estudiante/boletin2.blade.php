<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleta de Calificaciones</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f1f1f1;
            color: #000;
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
        }

        .header-main {
            background: linear-gradient(to right bottom, #1A4789 49.5%, #ffffff 50%);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .logo-izquierdo img,
        .logo-derecho img {
            max-height: 100px;
        }

        h1 {
            font-weight: 700;
            font-size: 24px;
        }

        .table th {
            background-color: #63becf;
            color: #fff;
        }

        .comentarios-input {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
        }

        .firma {
            width: 70px;
        }

        .custom-btn {
            background-color: #63becf;
            color: white;
            border-radius: 5px;
            padding: 10px 20px;
            margin: 10px;
            text-decoration: none;
        }
    </style>
</head>

<body>
<div class="container my-4">
    <div class="text-center mb-4">
        <a href="{{route('listacurso', $inscritos->cursos->id )}}" class="btn custom-btn">
            &#9668; Volver
        </a>
        <a href="#" class="btn custom-btn" id="generatePdfLink">Generar PDF</a>
    </div>

    <div id="container" class="bg-white p-4 rounded shadow">
        <div class="header-main d-flex justify-content-between align-items-center">
            <div class="logo-izquierdo">
                <img src="{{asset('assets/img/logof.png')}}" alt="Logo Izquierdo">
            </div>
            <div class="logo-derecho">
                <img src="{{asset('assets/img/Acceder.png')}}" alt="Logo Derecho">
            </div>
        </div>

        <div class="text-center mb-4">
            <h1>BOLETA DE CALIFICACIONES</h1>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <p><strong>Estudiante:</strong> {{$inscritos->estudiantes->name}} {{$inscritos->estudiantes->lastname1}} {{$inscritos->estudiantes->lastname2}}</p>
                <p><strong>Docente:</strong> {{$inscritos->cursos->docente->name}} {{$inscritos->cursos->docente->lastname1}} {{$inscritos->cursos->docente->lastname2}}</p>
                <p><strong>Periodo:</strong> {{ $inscritos->cursos->fecha_ini }} al {{ $inscritos->cursos->fecha_fin }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Curso:</strong> {{$inscritos->cursos->nombreCurso}}</p>
                <p><strong>Nivel:</strong> {{ $inscritos->cursos->nivel }}</p>
            </div>
        </div>

        <div class="table-responsive mb-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Diagnóstico</th>
                        <th>Nota</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($boletinNotas as $notas)
                    <tr>
                        <td>{{ strncmp("tareas", $notas->nota_nombre, 5) === 0 ? 'TAREAS' : 'EVALUACIONES' }}</td>
                        <td>{{ $notas->nota }}</td>
                    </tr>
                @endforeach

                @foreach ($inscritos->boletines as $boletin)
                    <tr>
                        <td><strong>NOTA FINAL</strong></td>
                        <td>{{ $boletin->nota_final }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mb-4">
            <p><strong>Comentarios y recomendaciones del docente:</strong></p>
            <div class="comentarios-input">
                @if(isset($boletin->comentario_boletin))
                    {{ $boletin->comentario_boletin }}
                @else
                    El Docente no hizo un comentario todavía
                @endif
            </div>
        </div>

        <div class="text-center">
            <img class="firma" src="{{asset('assets/img/firma digital.png')}}" alt="firma">
            <p><strong>Mba. Roxana Araujo Romay</strong></p>
            <p>Directora Ejecutiva</p>
            <p>DIRECCIÓN EJECUTIVA: FUNDACIÓN EDUCAR PARA LA VIDA</p>
        </div>
    </div>
</div>

<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('generatePdfLink').addEventListener('click', function (event) {
            event.preventDefault();
            const element = document.getElementById('container');

            html2pdf(element, {
                filename: 'boletin.pdf',
                margin: 10,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            });
        });
    });
</script>
</body>
</html>
