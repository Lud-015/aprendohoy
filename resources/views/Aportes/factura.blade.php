<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo Pago</title>

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
    </style>

</head>

<body>
<div class="border p-3">
        <div class="button-container">
            <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-primary custom-btn">
                &#9668; Volver
            </a>

            <a href="#" class="btn btn-primary custom-btn" id="generatePdfLink">Generar PDF</a>
            {{-- <form action="{{ route('enviarBoletinPost', $inscritos->id) }}" method="post">
                @csrf
                <button type="submit" class="btn btn-primary custom-btn">Enviar Correo</button>
            </form> --}}
        </div>
        <br>
        <br>
    </div>

<div class="container" id="container">
    <header id="header-main" class="header header-main header-expand-lg header-transparent header-light py-10">
        <div class="header-container">
            <div class="header-brand logo-izquierdo" >
                <img src="{{asset('assets/img/logof.png')}}" style="width: auto; height: 80px;">
            </div>
            <div class="header-brand logo-derecho" >
                <img src="{{asset('assets/img/logoedin.png')}}" style="width: auto; height: 125px;">
            </div>
        </div>
    </header>
    <div class="titulo-main">
        <h1>Recibo Cod. {{$aportes->codigopago}}</h1>
    </div>
    <div class="two-column-container">
        <div>
            <p>Estudiante:  {{$aportes->datosEstudiante}}</p>
            <p>Nombre:   {{$aportes->pagante}}</p>
            <p>CI:   {{$aportes->paganteci}} </p>
        </div>
        <div>
            <p>Fecha de emisión: {{$aportes->created_at}}</p>
            {{-- <p>Nivel: </p> --}}

        </div>
    </div>
    <div class="table-container">
        <table>
            <tr>
                <th>Descripcion</th>
                <th>Pago</th>
            </tr>

            <tr>
                <td style="max-width: 200px; word-wrap: break-word;">
                    {{$aportes->DescripcionDelPago}}
                </td>
                <td>
                    {{$aportes->monto_a_pagar}} Bs
                </td>
            </tr>

            <tr>
                <td style="display: flex; justify-content: flex-end;">Monto Cancelado</td>
                <td>{{$aportes->monto_pagado}} Bs</td>
            </tr>
            <tr>
                <td style="display: flex; justify-content: flex-end;">Restante a Pagar</td>
                <td>{{$aportes->restante_a_pagar}} Bs</td>
            </tr>
            <tr>
                <td style="display: flex; justify-content: flex-end;">Cambio</td>
                <td>{{$aportes->restante_a_pagar}} Bs</td>
            </tr>


        </table>


        <br><br><br>


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
                filename: 'factura {{$aportes->codigopago}} .pdf',

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
