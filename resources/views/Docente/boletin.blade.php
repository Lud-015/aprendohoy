<!DOCTYPE html>
<html lang="es" data-bs-theme="light">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Boleta de Calificaciones</title>

  <!-- Bootstrap CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <style>
    @font-face {
      font-family: AB;
      src: url(resources/fonts/AB.ttf);
    }

    body {
      background-color: #e8e8e8;
      color: #000;
      font-family: 'AB', sans-serif;
      text-align: center;
      margin: 0;
      padding: 0;
    }

    .header-main {
      background: linear-gradient(to right bottom, #1A4789 49.5%, #FFFF 50%);
      width: 55%;
      border: none;
      margin: 0 auto;
      border-radius: 10px;
    }

    .header-container {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
      padding: 1rem;
    }

    h1 {
      font-family: 'AB', sans-serif;
      font-size: 20px;
      margin-left: 20px;
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

    th, td {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }

    th {
      background-color: #63becf;
      color: #fff;
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
      margin: 10px;
      box-shadow: 0 0 10px #1a4789;
    }
  </style>
</head>

<body>

  <!-- Navbar Back Button -->
  <nav class="navbar bg-light border-bottom mb-4">
    <div class="container-fluid">
      <a href="javascript:history.back()" class="btn custom-btn">
        <i class="bi bi-arrow-left"></i> Volver
      </a>
    </div>
  </nav>

  <!-- Header -->
  <header class="header-main">
    <div class="header-container">
      <a class="header-brand logo-izquierdo" href="{{ route('Inicio') }}">
        <img src="{{ asset('resources/img/logof.png') }}" style="height: 80px;">
      </a>
      <a class="header-brand logo-derecho" href="{{ route('Inicio') }}">
        <img src="{{ asset('resources/img/logoedin.png') }}" style="height: 125px;">
      </a>
    </div>
  </header>

  <!-- Título -->
  <div class="mt-4">
    <h1>BOLETA DE CALIFICACIONES</h1>
  </div>

  <!-- Formulario -->
  <form action="{{ route('boletinPost', $inscritos->id) }}" method="POST">
    @csrf
    <div class="container">

      <!-- Datos generales -->
      <div class="two-column-container">
        <div class="text-start">
          <input type="text" name="estudiante" value="{{ $inscritos->id }}" hidden>
          <p><strong>Estudiante:</strong> {{ $inscritos->estudiantes->name }} {{ $inscritos->estudiantes->lastname1 }} {{ $inscritos->estudiantes->lastname2 }}</p>
          <p><strong>Docente:</strong> {{ $inscritos->cursos->docente->name }} {{ $inscritos->cursos->docente->lastname1 }} {{ $inscritos->cursos->docente->lastname2 }}</p>
          <p><strong>Periodo:</strong> {{ $inscritos->cursos->fecha_ini }} al {{ $inscritos->cursos->fecha_fin }}</p>
        </div>
        <div class="text-start">
          <p><strong>Curso:</strong> {{ $inscritos->cursos->nombreCurso }}</p>
          <p><strong>Nivel:</strong> {{ $inscritos->cursos->nivel }}</p>
        </div>
      </div>

      <!-- Tabla -->
      <div class="table-container">
        <table class="table table-bordered mt-3">
          <thead>
            <tr>
              <th>Diagnóstico</th>
              <th>Nota</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>EVALUACIONES</td>
              <td>
                @if($promedioNotasEvaluacion > 0)
                <input type="text" name="evaluaciones" value="evaluaciones {{ $inscritos->estudiantes->name }} {{ $inscritos->estudiantes->lastname1 }} {{ $inscritos->estudiantes->lastname2 }}" hidden>
                <input type="text" name="notaEvaluacion" value="{{ round($promedioNotasEvaluacion) }}" hidden>
                <p>{{ round($promedioNotasEvaluacion) }}</p>
                @else
                <p>No se encontraron notas para este estudiante.</p>
                @endif
              </td>
            </tr>
            <tr>
              <td>TAREAS</td>
              <td>
                @if($promedioNotasTareas > 0)
                <input type="text" name="tareas" value="tareas {{ $inscritos->estudiantes->name }} {{ $inscritos->estudiantes->lastname1 }} {{ $inscritos->estudiantes->lastname2 }}" hidden>
                <input type="text" name="notaTarea" value="{{ round($promedioNotasTareas) }}" hidden>
                <p>{{ round($promedioNotasTareas) }}</p>
                @else
                <p>No se encontraron notas para este estudiante.</p>
                @endif
              </td>
            </tr>
          </tbody>
        </table>

        <table class="table table-bordered">
          <tr>
            <td><strong>CALIFICACIÓN FINAL</strong></td>
            <td>
              <p>{{ round(($promedioNotasTareas + $promedioNotasEvaluacion) / 2) }}</p>
              <input type="text" name="notafinal" value="{{ round(($promedioNotasTareas + $promedioNotasEvaluacion) / 2) }}" hidden>
            </td>
          </tr>
        </table>

        <!-- Comentarios -->
        <div class="mt-3 text-start">
          <label for="comentario" class="form-label">Comentarios y recomendaciones del docente:</label>
          <textarea class="form-control comentarios-input" name="comentario" rows="4" required>{{ old('comentario') }}</textarea>
        </div>
      </div>

      <!-- Firma -->
      <div class="firma-container">
        <p>DIRECCIÓN EJECUTIVA: FUNDACIÓN EDUCAR PARA LA VIDA</p>
      </div>

      <!-- Botón submit -->
      <button type="submit" class="btn custom-btn">GUARDAR</button>
    </div>
  </form>

  <!-- Validaciones -->
  @if ($errors->any())
  <div class="alert alert-danger w-50 mx-auto mt-3">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  @if(session('success'))
  <div class="alert alert-success w-50 mx-auto mt-3">
    {{ session('success') }}
  </div>
  @endif

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>
