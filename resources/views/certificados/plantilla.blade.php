<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado de Participación</title>
    <style>
        @page {
            size: 11in 8.5in; /* Tamaño de hoja carta en orientación horizontal */
            margin: 0; /* Eliminar márgenes predeterminados */
        }

        body {
            text-align: center;
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            width: 100%;
            height: 100%;
            padding: 40px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            max-width: 120px;
        }

        .titulo {
            font-size: 32px;
            font-weight: bold;
            color: #2C3E50;
            margin-top: 20px;
        }

        .detalle {
            font-size: 18px;
            margin: 15px 0;
        }

        .nombre {
            font-size: 34px;
            font-weight: bold;
            color: #2980B9;
        }

        .firmas-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 80px;
            margin-top: 40px;
        }

        .firma {
            text-align: center;
        }

        .firma-img {
            max-width: 180px;
            display: block;
            margin: 0 auto;
        }

        .nombre-firma {
            font-size: 16px;
            font-weight: bold;
            margin-top: 5px;
        }

        .qr-container {
            position: absolute;
            bottom: 20px;
            left: 20px;
        }

        .qr-code {
            width: 120px;
        }

        .codigo {
            font-size: 14px;
            color: gray;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <img src="{{ storage_path('app/public/'.$logo) }}" alt="Logo" class="logo">
        </div>

        <h1 class="titulo">Certificado de Participación</h1>

        <p class="detalle">Se otorga el presente certificado a:</p>
        <p class="nombre">{{ $inscrito->estudiantes->name }}  {{ $inscrito->estudiantes->lastname1 }} {{ $inscrito->estudiantes->lastname2 }}</p>

        <p class="detalle">Por haber completado exitosamente el curso/congreso: <strong>{{ $curso }}</strong></p>

        <p class="detalle">Fecha de emisión: <strong>{{ $fecha_emision }}</strong></p>
        <p class="detalle">Fecha de finalización del curso: <strong>{{ $fecha_finalizacion }}</strong></p>

        <div class="firmas-container">
            <div class="firma">
                {{-- <img src="{{ storage_path('app/public/'.$firma1) }}" alt="Firma 1" class="firma-img"> --}}
                <p class="nombre-firma">Sara Doe</p>
            </div>
            <div class="firma">
                {{-- <img src="{{ storage_path('app/public/'.$firma2) }}" alt="Firma 2" class="firma-img"> --}}
                <p class="nombre-firma">Jhon Doe</p>
            </div>
        </div>

        <p class="codigo">Código de Certificado: <strong>{{ $codigo_certificado }}</strong></p>

        <div class="qr-container">
            <img src="{{ storage_path('app/public/'.$qr) }}" alt="Código QR" class="qr-code">
        </div>
    </div>

</body>
</html>
