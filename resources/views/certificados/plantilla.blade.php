<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <title>Certificado de Participación</title>
    <style>
        @page {
            size: 11in 8.5in;
            margin: 0;
        }

        @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

        body {

            text-align: center;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        .container {
            width: 100%;
            height: 100%;
            position: relative;
        }

        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
        }

        .nombre {
            font-family: "Bebas Neue", serif;
            font-weight: 400;
            font-size: 48px;
            font-style: normal;
            color: #2980B9;
            padding-top: 26%;
            position: relative;
        }

        .qr-container {
            position: absolute;
            bottom: 50px;
            left: 10px;
        }

        .qr-code {
            width: 100px;
        }

        .codigo {
            font-size: 14px;
            color: rgb(0, 0, 0);
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>

    <!-- Primera página (Frontal) -->
    <div class="container">
        <div class="background" style="background-image: url('{{ storage_path('app/public/' . $plantillaf) }}');"></div>
        <p class="nombre">{{ $inscrito->estudiantes->name }} {{ $inscrito->estudiantes->lastname1 }}
            {{ $inscrito->estudiantes->lastname2 }}</p>


        <div class="qr-container">
            <img src="{{ storage_path('app/public/' . $qr) }}" alt="Código QR" class="qr-code">
        </div>
    </div>

    <!-- Segunda página (Reverso) -->
    <div class="container">
        <div class="background" style="background-image: url('{{ storage_path('app/public/' . $plantillab) }}');">
            Código de Certificado: {{ $codigo_certificado }}</div>
    </div>

</body>

</html>
