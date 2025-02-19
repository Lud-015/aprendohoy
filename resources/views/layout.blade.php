<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        @yield('titulo')
    </title>
    <!-- Favicon -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="{{ asset('./assets/img/Acceder.png') }}" rel="icon" type="image/png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.5/perfect-scrollbar.min.js"></script>

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






<body >


    <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
        <div class="container-fluid">
            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
                aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Contenedor del Navbar -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Header del Navbar en modo colapsado -->
                <div class="navbar-collapse-header d-md-none">
                    <div class="row">
                        <div class="col-6 collapse-brand"></div>
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

                <!-- Perfil de Usuario -->
                <li class="dropdown col-3">

                    <a class="nav-item" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <div class="media align-items-center">
                            <span class="avatar avatar-sm rounded-circle">
                                @if (auth()->user()->avatar == '')
                                    <img src="{{ asset('./assets/img/user.png') }}" alt="Avatar of User">
                                @else
                                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar of User">
                                @endif
                            </span>
                            <span class="mb-0"> {{ auth()->user()->name }} {{ auth()->user()->lastname1 }} &#9660
                            </span>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-left">
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Bienvenid@!</h6>
                        </div>
                        <a href="{{ route('Miperfil') }}" class="dropdown-item">
                            <i class="ni ni-single-02"></i>
                            <span>Mi perfil</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}" class="dropdown-item">
                            <i class="ni ni-user-run"></i>
                            <span>Cerrar Sesión</span>
                        </a>
                    </div>
                </li>
                <hr>

                <!-- Generar menú dinámico según el rol del usuario -->
                @php
                    $navItems = [
                        'Administrador' => [
                            ['route' => 'Miperfil', 'icon' => 'ni ni-circle-08 text-green', 'text' => 'Mi perfil'],
                            ['route' => 'Inicio', 'icon' => 'ni ni-tv-2 text-primary', 'text' => 'Inicio', 'active' => true],
                            ['route' => 'ListadeCursos', 'icon' => 'ni ni-book-bookmark text-blue', 'text' => 'Lista de Cursos'],
                            ['route' => 'ListaDocentes', 'icon' => 'ni ni-single-02 text-blue', 'text' => 'Lista de Docentes'],
                            ['route' => 'ListaEstudiantes', 'icon' => 'ni ni-single-02 text-orange', 'text' => 'Lista de Estudiantes'],
                            ['route' => 'aportesLista', 'icon' => 'ni ni-bullet-list-67 text-red', 'text' => 'Aportes'],
                            ['route' => 'AsignarCurso', 'icon' => 'ni ni-key-25 text-info', 'text' => 'Asignación de Cursos'],
                        ],
                        'Docente' => [
                            ['route' => 'Miperfil', 'icon' => 'ni ni-circle-08 text-green', 'text' => 'Mi perfil'],
                            ['route' => 'Inicio', 'icon' => 'ni ni-tv-2 text-primary', 'text' => 'Mis Cursos', 'active' => true],
                            ['route' => 'AsignarCurso', 'icon' => 'ni ni-key-25 text-info', 'text' => 'Asignación de Cursos'],
                        ],
                        'Estudiante' => [
                            ['route' => 'Miperfil', 'icon' => 'ni ni-circle-08 text-green', 'text' => 'Mi perfil'],
                            ['route' => 'Inicio', 'icon' => 'ni ni-tv-2 text-primary', 'text' => 'Mis Cursos', 'active' => true],
                        ],
                    ];
                @endphp

                <ul class="navbar-nav">
                    @foreach ($navItems[auth()->user()->getRoleNames()->first()] ?? [] as $item)
                        <li class="nav-item {{ $item['active'] ?? false ? 'active' : '' }}">
                            <a class="nav-link{{ $item['active'] ?? false ? ' active' : '' }}"
                                href="{{ route($item['route']) }}">
                                <i class="{{ $item['icon'] }}"></i> {{ $item['text'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                @if (auth()->user()->hasRole('Estudiante'))
                @yield('nav')
                @else

                @endif





                <!-- Divider -->
                <hr class="my-3">

                <!-- Espacios Sociales -->
                <h6 class="navbar-heading text-muted">Nuestros Espacios</h6>
                <ul class="navbar-nav mb-md-3">
                    <li class="nav-item">
                        <a class="nav-link"
                            href="https://www.facebook.com/profile.php?id=100063510101095&mibextid=ZbWKwL">
                            <img src="{{ asset('assets/icons/fb.png') }}" alt="Facebook Icon"
                                style="width: 24px; margin-right: 10px;">
                            Facebook
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://instagram.com/fundeducarparalavida?igshid=MzRlODBiNWFlZA==">
                            <img src="{{ asset('assets/icons/ig.png') }}" alt="Instagram Icon"
                                style="width: 24px; margin-right: 10px;">
                            Instagram
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://www.tiktok.com/@educarparalavida?_t=8fbFcMbWOGo&_r=1">
                            <img src="{{ asset('assets/icons/tk.png') }}" alt="TikTok Icon"
                                style="width: 24px; margin-right: 10px;">
                            TikTok
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-content">

        <div class="header pb-6 pt-2 pt-md-4">
            <div class="container-fluid">
                <div class="header-body">
                    <nav id="navbar-main"
                        class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light py-10">
                        <div class="container">
                            <div class="navbar-container"> <a class="navbar-brand logo-izquierdo"
                                    href="{{ route('Inicio') }}"> <img src="{{ asset('../assets/img/logof.png') }}"
                                        style="width: auto; height: 80px;"> </a> <a class="navbar-brand logo-derecho"
                                    href="{{ route('Inicio') }}"> <img
                                        src="{{ asset('../assets/img/Acceder.png') }}"
                                        style="width: auto; height: 125px;"> </a> </div>
                        </div>
                    </nav> @yield('contentup') <style>
                        .navbar-main {
                            background: rgb(26,71,137);
                            background: linear-gradient(145deg, rgba(26,71,137,1) 40%, rgba(34,77,141,1) 53%, rgba(255,255,255,1) 53%);
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
                    </style> <!-- Card stats -->
                </div>
            </div>
        </div>





        <div class="container-fluid mt--7">

            <div class="row mt-5">
                <div class="col-xl-12">
                    <div class="card shadow">

                        <div class="table-responsive ">
                            @yield('content')
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


<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Restaurar la última pestaña activa
        let activeTab = localStorage.getItem("activeTab");
        if (activeTab) {
            let tab = document.querySelector(`[data-bs-target="${activeTab}"]`);
            if (tab) {
                new bootstrap.Tab(tab).show();
            }
        }

        // Guardar la pestaña seleccionada al hacer clic
        document.querySelectorAll(".nav-link").forEach(tab => {
            tab.addEventListener("click", function (event) {
                let tabTarget = event.target.getAttribute("data-bs-target");
                localStorage.setItem("activeTab", tabTarget);
            });
        });

        // Restaurar la última sección del accordion activa
        let activeAccordion = localStorage.getItem("activeAccordion");
        if (activeAccordion) {
            let accordionItem = document.querySelector(activeAccordion);
            if (accordionItem) {
                new bootstrap.Collapse(accordionItem, { toggle: true });
            }
        }

        // Guardar la sección del accordion cuando se abre
        document.querySelectorAll(".accordion-button").forEach(button => {
            button.addEventListener("click", function () {
                let accordionTarget = this.getAttribute("data-bs-target");
                localStorage.setItem("activeAccordion", accordionTarget);
            });
        });
    });
    </script>


<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: "{{ session('success') }}",
            confirmButtonText: 'Entendido'
        });
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: "{{ session('error') }}",
            confirmButtonText: 'Reintentar'
        });
    @endif
</script>



</body>

</html>
