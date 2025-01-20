  <!DOCTYPE html>
  <html lang="en">

  <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>
          Curso: @yield('titulo')
      </title>
      <!-- Favicon -->
      <link href="{{ asset('./assets/img/logoedin.png') }}" rel="icon" type="image/png">
      <!-- Fonts -->
      <!-- Icons -->
      <link href="{{ asset('./assets/js/plugins/nucleo/css/nucleo.css') }}" rel="stylesheet" />

      <link href="{{ asset('./assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
      <!-- CSS Files -->
      <link href="{{ asset('./assets/css/argon-dashboard.css') }}" rel="stylesheet" />
  </head>

  <body class="">
      <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
          <div class="container-fluid">
              <!-- Toggler -->


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
                  <span class="mb-0 text-sm  font-weight-bold"> {{auth()->user()->name}} {{auth()->user()->lastname1}} &#9660</span>
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

              <!-- Brand -->
              <hr class="my-3">
              <!-- User -->

              <!-- Collapse -->

                  <!-- Form -->

                  <!-- Navigation -->
                  @if (auth()->user()->hasRole('Administrador'))
                  <ul class="navbar-nav">
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('Miperfil') }}">
                              <i class="ni ni-circle-08 text-green"></i> Mi perfil
                          </a>
                      </li>
                      <li class="nav-item  active ">
                          <a class="nav-link  active " href="{{ route('Inicio') }}">
                              <i class="ni ni-tv-2 text-primary"></i> Mis Cursos
                          </a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link " href="{{ route('ListaDocentes') }}">
                              <i class="ni ni-single-02 text-blue"></i> Lista de Docentes
                          </a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link " href="{{ route('ListaEstudiantes') }}">
                              <i class="ni ni-single-02 text-orange"></i> Lista de Estudiantes
                          </a>
                      </li>

                      <li class="nav-item">
                          <a class="nav-link " href="{{ route('aportesLista') }}">
                              <i class="ni ni-bullet-list-67 text-red"></i> Aportes
                          </a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('AsignarCurso') }}">
                              <i class="ni ni-key-25 text-info"></i> Asignación de Cursos
                          </a>
                      </li>

                  </ul>
              @endif
              @if (auth()->user()->hasRole('Docente'))
                  <ul class="navbar-nav">
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('Miperfil') }}">
                              <img src="{{ asset('assets/icons/user.png') }}" alt="Mi perfil Icon"
                                  style="width: 16px; margin-right: 10px;">
                              Mi perfil
                          </a>
                      </li>
                      <li class="nav-item active">
                          <a class="nav-link active" href="{{ route('Inicio') }}">
                              <img src="{{ asset('assets/icons/cursos.png') }}" alt "cursos"
                                  style="width: 16px; margin-right: 10px;">
                              Mis Cursos
                          </a>
                      </li>
                      <li class="nav-item ">
                          <a class="nav-link" href="{{ route('pagos') }}">
                              <img src="{{ asset('assets/icons/pago.png') }}" alt "pago" style="width: 16px; margin-right: 10px;">
                              Mis Aportes
                          </a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('AsignarCurso') }}">
                              <img src="{{ asset('assets/icons/asignar.png') }}" alt="Asignar Cursos Icon"
                                  style="width: 16px; margin-right: 10px;">
                              Asignación de Cursos
                          </a>
                      </li>
                  </ul>
              @endif

              @if (auth()->user()->hasRole('Estudiante'))
                  <ul class="navbar-nav">
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('Miperfil') }}">
                              <img src="{{ asset('assets/icons/user.png') }}" alt="Mi perfil Icon"
                                  style="width: 16px; margin-right: 10px;">
                              Mi perfil
                          </a>
                      </li>
                      <li class="nav-item active">
                          <a class="nav-link active" href="{{ route('Inicio') }}">
                              <img src="{{ asset('assets/icons/cursos.png') }}" alt "cursos"
                                  style="width: 16px; margin-right: 10px;">
                              Mis Cursos
                          </a>
                      </li>
                      <li class="nav-item ">
                          <a class="nav-link" href="{{ route('pagos') }}">
                              <img src="{{ asset('assets/icons/pago.png') }}" alt "pago" style="width: 16px; margin-right: 10px;">
                              Mis Aportes
                          </a>
                      </li>

                  </ul>
              @endif

                  <!-- Divider -->
                  <hr class="my-3">
                  <!-- Heading -->
                  <h6 class="navbar-heading text-muted">Nuestros Espacios</h6>
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

                <a class="h1 mb-0 text-white text-uppercase d-none d-lg-inline-block"
                  href="/cursos/id/{{ $cursos->id }}">{{ $cursos->nombreCurso }}</a>

              </div>
          </nav>

          <!-- End Navbar -->
          <!-- Header -->

          @yield('contentup')

          <div class="container-fluid mt--7">

            @yield('content')

                      </div>



              <!-- Footer -->
              <footer class="footer ml--8">
                <div class="col-xl-6">
                    <div class="copyright text-right text-xl-right text-muted">
                      <script>
                          document.write("&copy; " + new Date().getFullYear() + " <a href='' target='_blank'>Fundación para educar la vida</a>.");
                      </script>
                    </div>
                </div>
                  <div class="row align-items-center justify-content-xl-between">

                      {{-- <div class="col-xl-6">
                          <ul class="nav nav-footer justify-content-center justify-content-xl-end">
                              <li class="nav-item">
                                  <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative
                                      Tim</a>
                              </li>
                              <li class="nav-item">
                                  <a href="https://www.creative-tim.com/presentation" class="nav-link"
                                      target="_blank">About Us</a>
                              </li>
                              <li class="nav-item">
                                  <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
                              </li>
                              <li class="nav-item">
                                  <a href="https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md"
                                      class="nav-link" target="_blank">MIT License</a>
                              </li>
                          </ul>
                      </div> --}}
                  </div>
              </footer>
          </div>
      </div>
  <!--   Core   -->
  <script src="{{asset('./assets/js/plugins/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('./assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <!--   Optional JS   -->
  <script src="{{asset('./assets/js/plugins/chart.js/dist/Chart.min.js')}}"></script>
  <script src="{{asset('./assets/js/plugins/chart.js/dist/Chart.extension.js')}}"></script>
  <!--   Argon JS   -->
  <script src="{{asset('./assets/js/argon-dashboard.min.js?v=1.1.2')}}"></script>
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
