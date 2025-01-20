<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        @yield('titulo')
    </title>
    <!-- Favicon -->
    <link href="{{ asset('./assets/img/logof.png') }}" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="{{ asset('./assets/js/plugins/nucleo/css/nucleo.css') }}" rel="stylesheet" />
    <link href="{{ asset('./assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="{{ asset('./assets/css/argon-dashboard.css?v=1.1.2') }}" rel="stylesheet" />
</head>

<style>
    .styled-textarea {
        width: 100%;
        height: 200px;
        padding: 10px;
        border: 2px solid #ccc;
        border-radius: 5px;
        resize: vertical;
        font-family: Arial, sans-serif;
        font-size: 14px;
    }
    .styled-textarea:focus {
        border-color: #66afe9;
        outline: none;
        box-shadow: 0 0 8px rgba(102, 175, 233, 0.6);
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const textarea = document.getElementById('autoSaveTextarea');
        const savedText = localStorage.getItem('autosave-text');
        if (savedText) {
            textarea.value = savedText;
        }
        textarea.addEventListener('input', () => {
            localStorage.setItem('autosave-text', textarea.value);
        });
    });
</script>






<body class="">


    <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">

        <div class="container-fluid">
            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
            aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>



            <!-- Brand -->

            <!-- User -->


            <!-- Collapse -->

            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Collapse header -->
                <div class="navbar-collapse-header d-md-none">
                    <div class="row">
                        <div class="col-6 collapse-brand">

                        </div>
                        <div class="col-6 collapse-close">
                            <button type="button" class="navbar-toggler" data-toggle="collapse"
                                data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                                aria-label="Toggle sidenav">
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>

                <li class="dropdown col-3">
                    <a class="nav-item " href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <div class="media align-items-center">
                            <span class="avatar avatar-sm rounded-circle">
                                @if (auth()->user()->avatar == '')
                                    <img src="{{ asset('./assets/img/user.png') }}" alt="Avatar of User">
                                @else
                                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar of User">
                                @endif
                            </span>
                            <span class="mb-0 "> {{ auth()->user()->name }}
                                {{ auth()->user()->lastname1 }} &#9660
                            </span>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-left">
                        <div class=" dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Bienvenid@!</h6>
                        </div>
                        <a href="{{ route('Miperfil') }}" class="dropdown-item">
                            <i class="ni ni-single-02"></i>
                            <span>Mi perfil</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}" class="dropdown-item">
                            <i class="ni ni-user-run"></i>
                            <span>Cerrar Sesion</span>
                        </a>
                    </div>


                </li>
                <hr>

                @if (auth()->user()->hasRole('Administrador'))
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('Miperfil') }}">
                                <i class="ni ni-circle-08 text-green"></i> Mi perfil
                            </a>
                        </li>
                        <li class="nav-item  active ">
                            <a class="nav-link  active " href="{{ route('Inicio') }}">
                                <i class="ni ni-tv-2 text-primary"></i> Inicio
                            </a>
                        </li>
                        <li class="nav-item   ">
                            <a class="nav-link  " href="{{ route('ListadeCursos') }}">
                                <i class="ni ni-book-bookmark text-blue"></i> Lista de Cursos
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
                                <i class="ni ni-circle-08 text-green"></i> Mi perfil
                            </a>
                        </li>
                        <li class="nav-item  active ">
                            <a class="nav-link  active " href="{{ route('Inicio') }}">
                                <i class="ni ni-tv-2 text-primary"></i> Mis Cursos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="./examples/tables.html">
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
                @if (auth()->user()->hasRole('Estudiante'))
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
                            <a class="nav-link " href="./examples/tables.html">
                                <i class="ni ni-bullet-list-67 text-red"></i> Mis Aportes
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
                            <img src="{{ asset('assets/icons/fb.png') }}" alt="TikTok Icon"
                                style="width: 24px; margin-right: 10px;">
                            Facebook
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://instagram.com/fundeducarparalavida?igshid=MzRlODBiNWFlZA==">
                            <img src="{{ asset('assets/icons/ig.png') }}" alt="TikTok Icon"
                                style="width: 24px; margin-right: 10px;">

                            Instagram
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="https://www.tiktok.com/@educarparalavida?_t=8fbFcMbWOGo&_r=1">
                            <img src="{{ asset('assets/icons/tk.png') }}" alt="TikTok Icon"
                                style="width: 24px; margin-right: 10px;">
                            Tiktok
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    <div class="main-content">


        <!-- Navbar -->
        {{-- <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">


        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="./index.html">@yield('titulo')</a>
        <!-- Form search -->

        <!-- User -->

      </div>
    </nav> --}}
        <!-- End Navbar -->
        <!-- Header -->

        <div class="header pb-6 pt-2 pt-md-4">
            <div class="container-fluid">
                <div class="header-body">
                    <nav id="navbar-main"
                        class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light py-10">
                        <div class="container">
                            <div class="navbar-container">
                                <a class="navbar-brand logo-izquierdo" href="{{ route('Inicio') }}">
                                    <img src="{{ asset('../assets/img/logof.png') }}"
                                        style="width: auto; height: 80px;">
                                </a>
                                <a class="navbar-brand logo-derecho" href="{{ route('Inicio') }}">
                                    <img src="{{ asset('../assets/img/logoedin.png') }}"
                                        style="width: auto; height: 125px;">
                                </a>

                            </div>

                        </div>
                    </nav>

                    @yield('contentup')

                    <style>
                        .navbar-main {
                            background: linear-gradient(to right bottom, #1A4789 49.5%, #FFFF 50%);
                            height: 140px;
                            /* Ajusta la altura de la navbar según sea necesario */
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
                    <!-- Card stats -->


                </div>
            </div>
        </div>




        <div class="container-fluid mt--7">

            <div class="row mt-5">
                <div class="col-xl-12">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">

                                        @yield('titulo')

                                    </h3>
                                </div>
                                <div class="col text-right">
                                    {{-- <a href="#!" class="btn btn-sm btn-success">Ver Todos</a>
                  <a href="#!" class="btn btn-sm btn-success">Crear Curso</a> --}}
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive ">
                            <table>

                                @yield('content')


                            </table>

                        </div>


                        @yield('contentini')

                    </div>
                </div>
            </div>
            <!-- Footer -->
            <footer class="footer">
                <div class="row align-items-center justify-content-xl-between">
                    <div class="col-xl-6">
                        <div class="copyright text-center text-xl-left text-muted">

                        </div>

                    </div>
                    <div class="col-xl-6">
                        <script>
                            document.write("&copy; " + new Date().getFullYear() +
                                " <a href='' target='_blank'>Fundación para educar la vida</a>.");
                        </script>
                        <ul class="nav nav-footer justify-content-center justify-content-xl-end">
                            {{-- <li class="nav-item">
                <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">About Us</a>
              </li>
              <li class="nav-item">
                <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
              </li> --}}
                            {{-- <li class="nav-item">
                <a href="https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md" class="nav-link" target="_blank">MIT License</a>
              </li> --}}
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!--   Core   -->
    <script src="{{ asset('./assets/js/plugins/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('./assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!--   Optional JS   -->
    <script src="{{ asset('./assets/js/plugins/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('./assets/js/plugins/chart.js/dist/Chart.extension.js') }}"></script>
    <!--   Argon JS   -->
    <script src="{{ asset('./assets/js/argon-dashboard.min.js?v=1.1.2') }}"></script>
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
