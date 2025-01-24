<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    @yield('titulo')
  </title>
  <!-- Favicon -->
  <link href="{{asset('../assets/img/brand/favicon.png')}}" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="{{asset('../assets/js/plugins/nucleo/css/nucleo.css')}}" rel="stylesheet" />
  <link href="{{asset('../assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="{{asset('../assets/css/argon-dashboard.css?v=1.1.2')}}" rel="stylesheet" />
</head>

<body class="">
  <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Brand -->


      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">

            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <!-- Form search -->

        <!-- Navigation -->

        <li class="dropdown">
            <a class="nav-link " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                    @if (auth()->user()->avatar == '')

                    <img  src="{{ asset('./assets/img/user.png') }}" alt="Avatar of User">

                    @else
                    <img  src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar of User">
                    @endif
                </span>
                <div class="media-body ml-1 d-none d-lg-block">
                  <span class="mb-0 text-sm  font-weight-bold"> {{auth()->user()->name}} {{auth()->user()->lastname1}}</span>
                </div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-left">
              <div class=" dropdown-header noti-title">
                <h6 class="text-overflow m-0">Bienvenid@!</h6>
              </div>
              <a href="{{route('Miperfil')}}" class="dropdown-item">
                <i class="ni ni-single-02"></i>
                <span>Mi perfil</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="{{route('logout')}}" class="dropdown-item">
                <i class="ni ni-user-run"></i>
                <span>Cerrar Sesion</span>
              </a>
            </div>
        </li>
 <hr class="my-3">
        @yield('nav')

        <!-- Divider -->
        <hr class="my-3">
        <!-- Heading -->
        <!-- Navigation -->
        <ul class="navbar-nav mb-md-3">
            <li class="nav-item">
                <a class="nav-link"
                    href="https://www.facebook.com/profile.php?id=100063510101095&mibextid=ZbWKwL">
                    <img src="{{ asset('assets/icons/fb.png') }}" alt="TikTok Icon" style="width: 24px; margin-right: 10px;">
                    Facebook
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://instagram.com/fundeducarparalavida?igshid=MzRlODBiNWFlZA==">
                <img src="{{ asset('assets/icons/ig.png') }}" alt="TikTok Icon" style="width: 24px; margin-right: 10px;">

                   Instagram
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="https://www.tiktok.com/@educarparalavida?_t=8fbFcMbWOGo&_r=1">
                    <img src="{{ asset('assets/icons/tk.png') }}" alt="TikTok Icon" style="width: 24px; margin-right: 10px;">
                    Tiktok
                </a>
            </li>
        </ul>

      </div>
    </div>
  </nav>
  <div class="main-content">
    <!-- Navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
        <!-- Brand -->

        <!-- Form search -->
        <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light py-10">
  <div class="container">
    <div class="navbar-container">
      <a class="navbar-brand logo-izquierdo" href="../index.html">
      <img src="{{asset('../assets/img/logof.png')}}" style="width: auto; height: 80px;">
      </a>
      <a class="navbar-brand logo-derecho" href="../index.html">
      <img src="{{asset('../assets/img/Acceder.png')}}" style="width: auto; height: 125px;">
      </a>
    </div>
  </div>
</nav>
<style>
.navbar-main {
    background: rgb(26,71,137);
    background: linear-gradient(145deg, rgba(26,71,137,1) 40%, rgba(34,77,141,1) 53%, rgba(255,255,255,1) 53%);
    height: 140px; /* Ajusta la altura de la navbar según sea necesario */
    width: 100%;
    border: none;
    border-radius: 0;
    position: relative;
    overflow: hidden;
  }

  /* Estilo para el contenedor de la navbar */
  .navbar-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 100%;
    width: 100%;
  }

  /* Estilo para los elementos de la navbar */
  .navbar-brand {
    height: 100%;
    width: auto;
    display: flex;
    align-items: center;
  }
  </style>

      </div>
    </nav>
    <!-- End Navbar -->
    <!-- Header -->
    <div class="header pb-2 pt-2 pt-lg-2 d-flex align-items-center" style="min-height: 350px; background-image: url(../assets/img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
      <!-- Mask -->

      <!-- Header container -->

    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
          <div class="card card-profile shadow">
            <div class="row justify-content-center">
              <div class="col-lg-3 order-lg-2">
                <div class="card-profile-image">
                    @yield('avatar')
                </div>
              </div>
            </div>
            <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
              {{-- <div class="d-flex justify-content-between">
                <a href="#" class="btn btn-sm btn-info mr-4">Connect</a>
                <a href="#" class="btn btn-sm btn-default float-right">Message</a>
              </div> --}}
            </div>
            <div class="card-body pt-0 pt-md-4">
                @yield('contentPerfil')
            </div>
          </div>
        </div>
        <div class="col-xl-8 order-xl-1">
          @yield('content')
        </div>
      </div>
      <!-- Footer -->
      <footer class="footer">
        <div class="row align-items-center justify-content-xl-between">
          <div class="col-xl-10">
            <div class="copyright text-center text-xl-left text-muted">
              &copy; 2023 <a href="https://educarparalavida.org.bo/" class="font-weight-bold ml-1" target="_blank">Fundacion Educar para la vida</a>
            </div>
          </div>

        </div>
      </footer>
    </div>
  </div>
  <!--   Core   -->
  <script src="{{asset('../assets/js/plugins/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('../assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <!--   Optional JS   -->
  <!--   Argon JS   -->
  <script src="{{asset('../assets/js/argon-dashboard.min.js?v=1.1.2')}}"></script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script>
    window.TrackJS &&
      TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "argon-dashboard-free"
      });
  </script>
</body>
</html>
