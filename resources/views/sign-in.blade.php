<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Iniciar Sesion
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <link href="../assets/css/font-awesome.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="../assets/css/argon-design-system.css?v=1.2.2" rel="stylesheet" />
</head>

<body class="login-page">
  <!-- Navbar -->

  <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light py-10">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center w-100">
      <a class="navbar-brand" href="../index.html">
        <img src="../assets/img/logo2.png" style="width: auto; height: 100px; /* Altura deseada */">
      </a>
      <a class="navbar-brand" href="../index.html">
        <img src="../assets/img/logoedin.png" style="width: auto; height: 120px; /* Altura deseada */">
      </a>
    </div>
  </div>
</nav>



  <!-- End Navbar -->
  <section class="section section-shaped section-lg">
    <div class="shape shape-style-1 bg-success">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
    </div>
    @if (auth()->check())
    <div class="container pt-lg-6">
      <div class="row justify-content-center">
        <div class="col-lg-5">
          <div class="card bg-secondary shadow border-0">

            <div class="card-body px-lg-5 py-lg-5">
              <div class="text-center text-muted mb-4">
                <h5>Ya Iniciaste Sesion</h5>
                <a href="{{route('Inicio')}}"><button type="submit" class="btn btn-success my-4">Volvel al incio</button></a>
              </div>

            </div>

          </div>


        </div>

      </div>

    </div>
    @else
    <div class="container pt-lg-6">
  <div class="row justify-content-center"> <!-- Cambia justify-content-left a justify-content-center -->
    <div class="col-lg-5 mx-auto"> <!-- Agrega mx-auto para centrar el contenido -->
      <div class="card bg-secondary shadow border-0">

            <div class="card-body px-lg-5 py-lg-5">
              <div class="text-center text-muted mb-4">
                <h5>Iniciar Sesion</h5>
              </div>
              <form role="form" method="post">
                @csrf
                <div class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input class="form-control" placeholder="Correo Electronico" type="email" name="email">
                  </div>
                </div>
                <div class="form-group focused">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" placeholder="Contraseña" type="password" name="password">
                  </div>
                </div>
                {{-- <div class="custom-control custom-control-alternative custom-checkbox">
                  <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
                  <label class="custom-control-label" for=" customCheckLogin"><span>Recordarme</span></label>
                </div> --}}
                <div class="text-center">
                  <button type="submit" class="btn btn-info my-4">Acceder</button>
                </div>
              </form>
            </div>
            @foreach ($errors->get('email') as $error)
            <span class="badge badge-pill badge-danger text-uppercase">{{ $error }}</span>
            @endforeach
          </div>
          <div class="row mt-3">
            <div class="col-6">
              <a href="#" class="text-light"><small>Olvidaste tu contraseña?</small></a>
            </div>
            <div class="col-6 text-right">
              <a href="" class="text-light"><small>Crear una nueva cuenta</small></a>
            </div>
          </div>
          <div class="container mt-4">
    </div>
    @endif
  </section>
  <style>
  /* Estilos personalizados para las imágenes redondas con borde */
  .rounded-image {
    width: 200px; /* Ancho deseado para todas las imágenes */
    height: 200px; /* Alto deseado para todas las imágenes */
    border-radius: 50%; /* Hace que la imagen sea redonda */
    object-fit: cover; /* Mantiene la relación de aspecto y recorta las imágenes para que encajen */
    border: 5px solid #39a6cb; /* Agrega un borde redondeado de color #39a6cb */
  }
  .custom-box {
    background-color: #b8e2fc;
    border: 5px solid #39a6cb; /* Borde de 5px de color #39a6cb */
    border-radius: 20px; /* Bordes redondeados */
    padding: 8px; /* Espaciado interior */
    color: black; /* Color del texto */
  }
  /* Estilo para el fondo de la sección con degradado */
  .section-bg {
    background: linear-gradient(to bottom, white, #b8e2fc); /* Degradado de blanco a celeste */
    color: black; /* Color del texto */
  }
</style>
<div class="container-fluid mt-4 section-bg"> <!-- Aplicar la clase "section-bg" para el fondo de la sección -->
  <div class="text-center mb-4">
    <h3>"FUNDACIÓN EDUCAR PARA LA VIDA"</h3>
    <h3>se sostiene en tres pilares fundamentales</h3>
  </div>
  <div class="row">
    <div class="col-lg-4">
      <div class="text-center">
        <h3>LA EDUCACIÓN</h3>
        <img src="../assets/img/img1.jpeg" alt="Imagen 1" class="img-fluid rounded-image">
      </div>
      <div class="text-center mt-2">
        <div class="custom-box">
          <p>Como el arte y el servicio de encaminar a los nuevas generaciones a una vida plena. Una educación desde, en y para la vida plena.</p>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="text-center">
        <h3>LA VIDA</h3>
        <img src="../assets/img/img2.png" alt="Imagen 2" class="img-fluid rounded-image">
      </div>
      <div class="text-center mt-2">
        <div class="custom-box">
          <p>Como el don y el compromiso más importante de las personas. Educamos para mejorar integralmente la calidad de la vida de todo ser humano, especialmente de las personas de escasos recursos.</p>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="text-center">
        <h3>EL SERVICIO</h3>
        <img src="../assets/img/img3.jpeg" alt="Imagen 3" class="img-fluid rounded-image">
      </div>
      <div class="text-center mt-2">
        <div class="custom-box">
          <p>Como la estrategia y el perfil de nuestro accionar "Vivimos para servir"</p>
        </div>
      </div>
    </div>
  </div>
  <br> </br>
</div>
  <footer class="footer">
    <div class="container">
      <div class="row row-grid align-items-center mb-5">
        <div class="col-lg-6">
          <h3 class="text-primary font-weight-light mb-2">Gracias por la visita!</h3>

        </div>
      </div>
      <hr>

      <div class="row align-items-center justify-content-md-between">
        <div class="col-md-6">
          <div class="copyright">
            &copy; 2023 <a href="" target="_blank">Fundacion para educar la vida</a>.
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js" type="text/javascript"></script>
  <script src="../assets/js/core/popper.min.js" type="text/javascript"></script>
  <script src="../assets/js/core/bootstrap.min.js" type="text/javascript"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
  <script src="../assets/js/plugins/bootstrap-switch.js"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="../assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
  <script src="../assets/js/plugins/moment.min.js"></script>
  <script src="../assets/js/plugins/datetimepicker.js" type="text/javascript"></script>
  <script src="../assets/js/plugins/bootstrap-datepicker.min.js"></script>
  <!-- Control Center for Argon UI Kit: parallax effects, scripts for the example pages etc -->
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <script src="../assets/js/argon-design-system.min.js?v=1.2.2" type="text/javascript"></script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script>
    window.TrackJS &&
      TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "argon-design-system-pro"
      });
  </script>
</body>

</html>
