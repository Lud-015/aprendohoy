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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
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

<style>
    .sidebar {
        width: 250px;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        background: rgb(26, 71, 137);
        padding: 1rem;
        transition: all 0.3s;
        overflow: hidden;
    }


    .sidebar.collapsed {
        width: 80px;
    }

    .sidebar a {
        color: white;
        text-decoration: none;
        padding: 10px;
        display: block;
        transition: 0.3s;
    }

    .sidebar a:hover {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 5px;
    }

    .sidebar .nav-link i {
        font-size: 20px;
        margin-right: 10px;
        transition: 0.3s;
    }

    .sidebar.collapsed .nav-link span {
        display: none;
    }

    .sidebar.collapsed .nav-link i {
        margin-right: 0;
    }

    /* Sidebar con scroll */
    .sidebar-menu {
        overflow-y: auto;
        max-height: calc(100vh - 150px);
        /* Ajuste dinámico según el contenido */
        padding-right: 10px;
    }

    /* Ocultar scrollbar en navegadores modernos */
    .sidebar-menu::-webkit-scrollbar {
        width: 6px;
    }

    /* Sidebar colapsado */
    .sidebar.collapsed {
        width: 80px;
    }

    .sidebar.collapsed .user-name {
        display: none !important;
    }

    .sidebar.collapsed .sidebar-menu {
        max-height: calc(100vh - 100px);
    }

    .sidebar-menu::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }

    /* Contenido principal */
    .content {
        margin-left: 250px;
        transition: all 0.3s;
        padding: 2rem;
    }

    .collapsed+.content {
        margin-left: 80px;
    }

    /* Botón de toggler */
    .sidebar-toggler {
        background: none;
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
        width: 100%;
        text-align: left;
    }

    .sidebar-toggler:focus {
        outline: none;
    }

    .user-avatar {
        transition: transform 0.3s ease-in-out;
        cursor: pointer;
    }

    .user-avatar:hover {
        transform: scale(1.1);
        /* Efecto de agrandado al pasar el mouse */
    }

    /* Esconder el nombre cuando el sidebar está colapsado */
    .sidebar.collapsed .user-name {
        display: none !important;
    }

</style>






<body>



    <!-- Bootstrap y Script -->


    <!-- Agregar Bootstrap 5 JS -->
    @php
        $navItems = [
            'Administrador' => [
                ['route' => 'Inicio', 'icon' => 'bi bi-house-door ', 'text' => 'Inicio', 'active' => true],
                ['route' => 'ListadeCursos', 'icon' => 'bi bi-journal-bookmark ', 'text' => 'Lista de Cursos'],
                ['route' => 'ListaDocentes', 'icon' => 'bi bi-people ', 'text' => 'Lista de Docentes'],
                ['route' => 'ListaEstudiantes', 'icon' => 'bi bi-people ', 'text' => 'Lista de Estudiantes'],
                ['route' => 'aportesLista', 'icon' => 'bi bi-wallet ', 'text' => 'Lista de Pagos'],
                ['route' => 'AsignarCurso', 'icon' => 'bi bi-person-lines-fill', 'text' => 'Asignación de Cursos'],
            ],
            'Docente' => [
                [
                    'route' => 'Inicio',
                    'icon' => 'bi bi-house-door ',
                    'text' => 'Mis Cursos',
                    'active' => true,
                ],
                ['route' => 'AsignarCurso', 'icon' => 'bi bi-key ', 'text' => 'Asignación de Cursos'],
                ['route' => 'sumario', 'icon' => 'bi bi-pencil-square ', 'text' => 'Sumario'],
                // ['route' => 'cal', 'icon' => 'bi bi-folder text-info', 'text' => 'Material de Apoyo'],
            ],
            'Estudiante' => [
                [
                    'route' => 'Inicio',
                    'icon' => 'bi bi-house-door text-primary',
                    'text' => 'Mis Cursos',
                    'active' => true,
                ],
                // ['route' => 'Notas', 'icon' => 'bi bi-award text-warning', 'text' => 'Mis Notas'],
                // ['route' => 'Materiales', 'icon' => 'bi bi-folder text-info', 'text' => 'Material de Apoyo'],
                ['route' => 'pagos', 'icon' => 'bi bi-wallet text-danger', 'text' => 'Pagos y Facturación'],
            ],
        ];
    @endphp

    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column" id="sidebar">
        <!-- Botón para colapsar el sidebar -->
        <button class="sidebar-toggler" id="toggleSidebar">
            <i class="bi bi-list"></i>
        </button>

        <!-- Perfil del Usuario -->
        <div class="user-profile text-center mt-3">
            <a href="{{ route('Miperfil') }}" class="d-flex align-items-center justify-content-center">
                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('./assets/img/user.png') }}"
                    alt="Avatar of User" class="img-fluid rounded-circle user-avatar" width="60">
                <span class="user-name ms-2 text-white fw-bold d-none d-lg-block">{{ auth()->user()->name }}
                    {{ auth()->user()->lastname1 }}</span>
            </a>
        </div>

        <hr class="bg-white my-3">

        <!-- Menú con Scroll -->
        <div class="sidebar-menu">
            @foreach ($navItems[auth()->user()->getRoleNames()->first()] ?? [] as $item)
                <a href="{{ route($item['route']) }}" class="nav-link">
                    <i class="{{ $item['icon'] }}"></i> <span>{{ $item['text'] }}</span>
                </a>
            @endforeach

            <!-- Cerrar sesión -->
            <a href="{{ route('logout') }}" class="nav-link text-danger">
                <i class="bi bi-box-arrow-right"></i> <span>Salir</span>
            </a>
        </div>
    </div>
    {{-- NAV --}}


    <div class="content">
        <div class="header  pt-2 pt-md-4">
            <div class="container-fluid">
                <div class="header-body">
                    <style>
                        /* Navbar Estilos */
                        .navbar-main {
                            background: linear-gradient(145deg, rgba(26, 71, 137, 1) 40%, rgba(34, 77, 141, 1) 53%, rgba(255, 255, 255, 1) 53%);
                            width: 100%;
                            border: none;
                            position: relative;
                            overflow: hidden;
                            padding: 15px 20px;
                            /* Espaciado interno */
                        }

                        /* Contenedor de la navbar */
                        .navbar-container {
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            width: 100%;
                        }

                        /* Ajuste de la altura y tamaño del navbar en pantallas grandes */
                        @media (min-width: 992px) {
                            .navbar-main {
                                height: 140px;
                                /* Solo en pantallas grandes */
                            }
                        }

                        /* Ajustes de logos */
                        .navbar-brand img {
                            max-height: 80px;
                            /* Tamaño máximo del logo */
                            width: auto;
                        }

                        /* Logo derecho (Acceder) más pequeño */
                        .logo-acceder img {
                            max-height: 45px;
                        }

                        /* Responsividad: Ajustar la navbar en pantallas pequeñas */
                        @media (max-width: 768px) {
                            .navbar-main {
                                height: auto;
                                /* Altura dinámica en móviles */
                                padding: 10px 15px;
                                /* Reducir padding */
                            }

                            .navbar-container {
                                flex-direction: column;
                                /* Elementos en columna */
                                text-align: center;
                                gap: 10px;
                                /* Separación entre logos */
                            }

                            .navbar-brand img {
                                max-height: 20px;
                            }

                            .logo-acceder img {
                                max-height: 10px;
                            }
                        }
                    </style> <!-- Card stats -->
                    <!-- Navbar -->
                    <nav id="navbar-main" class="navbar navbar-expand-lg navbar-light navbar-main">
                        <div class="container d-flex justify-content-between align-items-center">
                            <!-- Logo izquierdo -->
                            <a class="navbar-brand" href="{{ route('Inicio') }}">
                                <img src="{{ asset('../assets/img/logof.png') }}" alt="Logo Izquierdo" class="logo"
                                   >
                            </a>

                            <!-- Logo derecho -->
                            <a class="logo-acceder" href="{{ route('Inicio') }}">
                                <img src="{{ asset('../assets/img/Acceder.png') }}" alt="Logo Derecho"
                                    class="logo-acceder" >
                            </a>
                        </div>
                    </nav>
                    <!-- Contenido adicional -->
                    @yield('contentup')
                </div>
            </div>
        </div>






        <div class="container-fluid mt-4">
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="table-responsive">
                                @yield('content')
                            </div>
                            @yield('contentini')
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="footer mt-4">
                <div class="container">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-md-6 text-center text-md-start text-muted">
                            &copy; <script>document.write(new Date().getFullYear());</script>
                            <a href="#" target="_blank">Fundación para educar la vida</a>.
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <!-- Espacio para enlaces adicionales si los necesitas -->
                        </div>
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
        document.addEventListener("DOMContentLoaded", function() {
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
                tab.addEventListener("click", function(event) {
                    let tabTarget = event.target.getAttribute("data-bs-target");
                    localStorage.setItem("activeTab", tabTarget);
                });
            });

            // Restaurar la última sección del accordion activa
            let activeAccordion = localStorage.getItem("activeAccordion");
            if (activeAccordion) {
                let accordionItem = document.querySelector(activeAccordion);
                if (accordionItem) {
                    new bootstrap.Collapse(accordionItem, {
                        toggle: true
                    });
                }
            }

            // Guardar la sección del accordion cuando se abre
            document.querySelectorAll(".accordion-button").forEach(button => {
                button.addEventListener("click", function() {
                    let accordionTarget = this.getAttribute("data-bs-target");
                    localStorage.setItem("activeAccordion", accordionTarget);
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("toggleSidebar").addEventListener("click", function() {
            document.querySelector(".sidebar").classList.toggle("collapsed");
            document.querySelector(".content").classList.toggle("collapsed");
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
    <script>
        var botmanWidget = {
            title: 'Soporte',
            mainColor: '#0d6efd',
            bubbleBackground: '#0d6efd',
            aboutText: 'ChatBot Laravel',
            introMessage: "¡Hola! ¿En qué puedo ayudarte?"
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js"></script>



</body>

</html>
