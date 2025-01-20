<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/logoedin.png">
  <title>
    Iniciar Sesion
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="../assets/fonts/atma-gold.ttf">
  <link rel="stylesheet" type="text/css" href="../assets/fonts/alegreya-sans-black.ttf">
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <link href="../assets/css/font-awesome.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="../assets/css/argon-design-system.css" rel="stylesheet" />
  <link href="../assets/css/log.css" rel="stylesheet" />
</head>
<!-- Navbar -->
<nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light py-10">
  <div class="container">
    <div class="navbar-container">
      <div class="navbar-brand logo-izquierdo" >
        <img src="../assets/img/logof.png" style=" height: 65px;">
    </div>
      <a class="navbar-brand logo-derecho ml-auto" >
        <img src="../assets/img/logoedin.png" style=" height: 105px;">
      </a>
    </div>
  </div>
</nav>
{{-- <style>
    body {
        margin: 0;
        padding: 0;
        background-color: #ffffff;
    }

    .card {
        position: relative;
        width: 100%;
        max-width: 1200px;
        height: 200px;
        margin: 20px auto;
        background: linear-gradient(342deg, rgba(255, 255, 255, 1) 46%, rgba(0, 82, 203, 1) 46%);
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 20px;
        box-sizing: border-box;
        overflow: hidden;
    }

    .logo {
        max-width: 200px;
        max-height: 100px;
    }

    .background {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #0052cb;
        transform: skewY(-18deg);
        transform-origin: top left;
        z-index: 0;
    }

    .content {
        position: relative;
        z-index: 1;
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>


<div class="card">
    <div class="background"></div>
    <div class="content">
        <img src="../assets/img/logof.png" alt="Logo Fundación Educar para la Vida" class="logo">
        <img src="../assets/img/logoedin.png" alt="Logo Educación Integral e Inclusiva" class="logo">
    </div>
</div> --}}

<!-- End Navbar -->
<body class="login-page">

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
                    <h5>Ya Iniciaste Sesión</h5>
                     <a href="{{route('Inicio')}}"><button type="submit" class="btn btn-custom my-4">Volver al inicio</button></a>
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
                <h5>Iniciar Sesión</h5>
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
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility(this)">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>

                </div>
                {{-- <div class="custom-control custom-control-alternative custom-checkbox">
                  <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
                  <label class="custom-control-label" for=" customCheckLogin"><span>Recordarme</span></label>
                </div> --}}
                <div class="text-center">
                     <button type="submit" class="btn btn-custom my-4 atma">Acceder</button>
                </div>
              </form>
            </div>
            @foreach ($errors->get('email') as $error)
            <span class="badge badge-pill badge-danger text-uppercase">{{ $error }}</span>
            @endforeach
          </div>

          <div class="container mt-4">
    </div>
    @endif
  </section>

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
                <script>
                    document.write("&copy; " + new Date().getFullYear() + " <a href='' target='_blank'>Fundación para educar la vida</a>.");
                </script>
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
  <script>
    function togglePasswordVisibility(button) {
        var passwordInput = button.parentNode.previousElementSibling;
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            button.innerHTML = '<i class="fa fa-eye-slash"></i>';
        } else {
            passwordInput.type = "password";
            button.innerHTML = '<i class="fa fa-eye"></i>';
        }
    }
</script>
</body>
</html>
