<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Certificado</title>
  <style>
    @font-face{
        font-family: AB;
        src: url(resources/fonts/AB.ttf);
    }

    @font-face{
        font-family: 'ASB', sans-serif;
        src: url({{asset('assets/fonts/ASB.ttf')}});
    }

    body {
      font-family: 'ASB', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }

    .main-container {
      width: 100%;
      overflow: hidden;
    }

    .certificate-container {
      width: 792px;
      height: 632PX;
      margin: 50px auto;
      background-color: #fff;
      padding: 0px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      position: relative;
      overflow: hidden;
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      background-image: url('{{ asset("assets/img/fondo.jpg") }}');
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .certificate-content-container {
      text-align: center;
      margin-top: 0px;
    }

    .certificate-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: 0px;
      margin-bottom: 25px;
    }

    .certificate-title {
      font-size: 24px;
      color: #1a4789;
      text-align: center;
      font-family: 'ASB', sans-serif;
      margin-top: 15px;
      margin-bottom: 20px;
    }

    .certificate-logo {
      margin-left: 100px;
      margin-right: 25px;
      margin-top: 20px;
      width: 120px;
      height: auto;
    }

    .certificate-logo-f {
      width: 170px;
      height: auto;
      margin-right: 340px;
      display: inline-block;

    }
    .firma {
      width: 55px;
      height: auto;
      display: inline-block;
    }

    .certificate-content {
      text-align: left;
      margin-bottom: 50px;

    }

    .certificate-text {
      margin-top: 14px;
      margin-left: 20px;
      margin-right: 20px;
      color: #1a4789;
      font-family: 'ASB', sans-serif;
    }

    .certificate-nombre {
      margin-top: 14px;
      text-align: center;
      color: #1a4789;
      font-family: 'AB', sans-serif;
    }

    .certificate-signature {
      color: #1a4789;
      font-size: 11px;
      line-height: 1;
      font-family: 'ASB', sans-serif;
      margin-bottom: 60px;
    }

    .download-link {
      text-align: center;
      margin-top: 20px;
      margin-bottom: 20px;
    }

    .download-link a {
      display: inline-block;
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
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
            <a href="javascript:history.back()" class="btn btn-primary custom-btn">
                &#9668; Volver<br>
            </a>

            <a href="#" class="btn btn-primary custom-btn" id="generatePdfLink">Generar PDF</a>
        </div>
        <br>
        <br>
    </div>


  <div class="main-container" id="container">
    <div class="certificate-container">
      <div class="certificate-header">
        <div style="width: 100%; height: auto;"></div>
        <img class="certificate-logo-f" src="{{asset('assets/img/logof.png')}}" alt="Logo F">
        <img class="certificate-logo" src="{{asset('assets/img/logoedin.png')}}" alt="Logo Edin">
      </div>

      <div class="certificate-content-container">
        <h1 class="certificate-title">CERTIFICADO</h1>
        <div class="certificate-content">
          <p class="certificate-text">Se otorga el presente certificado a:</p>
          <h2 class="certificate-nombre">{{$inscritos->estudiantes->name}} {{$inscritos->estudiantes->lastname1}} {{$inscritos->estudiantes->lastname2}}</h2>
          <h4 class="certificate-text">
            Por haber completado con éxito el curso de {{$inscritos->cursos->nombreCurso}}.
            Este certificado se otorga en reconocimiento a su dedicación y logros al haber obtenido como promedio final: {{$boletin->nota_final}}.
            En un periodo de tiempo de {{$inscritos->cursos->fecha_ini}} a {{$inscritos->cursos->fecha_fin}}.
          </h4>

          <p class="certificate-text" style="text-align: right;">
            Bolivia, {{$boletin->created_at->day}} de {{$boletin->created_at->locale('es')->format('F')}} del {{$boletin->created_at->year}}
          </p>
        </div>

        <div class="certificate-signature">
        <img class="firma" src="{{asset('assets/img/firma digital.png')}}" alt="Firma Digital">
          <p>Mba. Roxana Araujo Romay</p>
          <p>Directora Ejecutiva</p>
        </div>
        <br>
      </div>
    </div>
  </div>

  <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Función para generar el PDF
        function generatePdf() {
            var element = document.getElementById('container');

            html2pdf(element, {
                filename: 'certificado.pdf',
                jsPDF: { orientation: 'landscape' },
            }).then(function (pdf) {
                console.log('PDF generado correctamente:', pdf);
            }).catch(function (error) {
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
</script>

</body>
</html>
