<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Certificado</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
            size: A4 landscape;
        }

        body {
            font-family: 'Montserrat', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        .container {
            width: 100%;
            max-width: 1050px;
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
        }

        .certificate {
            position: relative;
            padding: 30px;
            border: 4px double #1a4789;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .certificate-header {
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-container {
            display: inline-block;
            width: 45%;
            height: 80px;
            text-align: center;
            vertical-align: middle;
        }

        .logo {
            max-height: 80px;
            max-width: 100%;
        }

        .certificate-title {
            font-family: 'Georgia', serif;
            font-size: 28pt;
            color: #1a4789;
            text-align: center;
            margin: 20px 0;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 2px solid #1a4789;
            padding-bottom: 10px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        .certificate-content {
            margin: 20px 40px;
        }

        .certificate-text {
            font-size: 14pt;
            color: #1a4789;
            margin: 10px 0;
            line-height: 1.6;
            text-align: justify;
        }

        .student-name {
            font-family: 'Georgia', serif;
            font-size: 22pt;
            color: #1a4789;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            padding-bottom: 5px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        .certificate-footer {
            text-align: right;
            font-size: 10pt;
            color: #1a4789;
            margin-top: 20px;
            padding-top: 10px;
        }

        .signature {
            text-align: center;
            margin-top: 60px;
            position: relative;
        }

        .signature-line {
            width: 200px;
            height: 1px;
            background-color: #1a4789;
            margin: 10px auto;
        }

        .signature p {
            margin: 5px 0;
            font-size: 10pt;
            color: #1a4789;
        }

        strong {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="certificate">
            <div class="certificate-header">
                <div class="logo-container">
                    <img src="data:image/png;base64,{{ $logoF }}" alt="Logo F" class="logo">
                </div>
                <div class="logo-container">
                    <img src="data:image/png;base64,{{ $logoEdin }}" alt="Logo Edin" class="logo">
                </div>
            </div>

            <h1 class="certificate-title">CERTIFICADO</h1>

            <div class="certificate-content">
                <p class="certificate-text">Se otorga el presente certificado a:</p>
                <h2 class="student-name">{{ $estudiante->name }} {{ $estudiante->lastname1 }} {{ $estudiante->lastname2 }}</h2>
                <p class="certificate-text">
                    Por haber completado con éxito el curso de <strong>{{ $curso->nombreCurso }}</strong>.
                    Este certificado se otorga en reconocimiento a su dedicación y logros al haber obtenido como
                    promedio final: <strong>100</strong>.
                    En un periodo de tiempo de <strong>{{ $curso->fecha_ini }}</strong> a
                    <strong>{{ $curso->fecha_fin }}</strong>.
                </p>
                <p class="certificate-footer">
                    Fecha de emisión: <strong>{{ $fecha }}</strong><br>
                    Código de validación: <strong>{{ $codigo }}</strong>
                </p>
            </div>

            <div class="signature">
                <img src="data:image/png;base64,{{ $firma }}" alt="Firma Digital" style="max-height: 55px;">
                <p>Mba. Roxana Araujo Romay</p>
                <p>Directora Ejecutiva</p>
            </div>

            <div>
                <img src="data:image/png;base64,{{ $qrCode }}" alt="Código QR">
            </div>
        </div>
    </div>
</body>
</html>
