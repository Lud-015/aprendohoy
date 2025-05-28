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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" lrel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="{{ asset('./assets/js/plugins/nucleo/css/nucleo.css') }}" rel="stylesheet" />
    <link href="{{ asset('./assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('./assets/js/argon-dashboard.min.js') }}" rel="stylesheet" />





    <!-- CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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
<style>
    /* Paleta de colores */
:root {
    --primary-color: #2197BD;  /* Azul oscuro */
    --secondary-color: #39a6cb; /* Celeste */
    --tertiary-color: #63becf;  /* Azul claro */
    --info-color: #63becf;
    --light-blue: #2197BD;
    --dark-blue: #145DA0;
    --extra-blue: #2A81C2;
    --success-color: #198754; /* Mantiene el verde Bootstrap */
}

bg-third

/* Estilos generales de la tabla */
.table {
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(255, 255, 255, 0.1); /* Sombra suave */
}

.bg-sec {
    background-color: var(--primary-color);
}

/* Encabezado de la tabla */
.table thead {
    background-color: #1a4789; /* Azul oscuro */
    color: white;
}

/* Bordes y espaciado en celdas */
.table th,
.table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd; /* Línea separadora */
}

/* Filas alternas con color */
.table tbody tr:nth-child(even) {
    background-color: #f2f2f2; /* Gris claro */
}

/* Hover en filas */
.table tbody tr:hover {
    background-color: #d7ebf4; /* Azul claro */
    transition: background 0.3s ease-in-out;
}


/* Cambiar colores de botones */
.btn-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.btn-primary:hover {
    background-color: var(--secondary-color);
    border-color: var(--secondary-color);
}

.btn-info {
    background-color: var(--info-color);
    border-color: var(--info-color);
}

.btn-info:hover {
    background-color: var(--light-blue);
    border-color: var(--light-blue);
}

/* Personalizar texto */
.text-primary {
    color: var(--primary-color) !important;
}

.text-info {
    color: var(--info-color) !important;
}

</style>






<body>
    @php
        $navItems = [
            'Administrador' => [
                ['route' => 'Inicio', 'icon' => 'bi bi-house-door', 'text' => 'Inicio', 'active' => true],
                ['route' => 'ListadeCursos', 'icon' => 'bi bi-journal-bookmark', 'text' => 'Lista de Cursos'],
                ['route' => 'ListaDocentes', 'icon' => 'bi bi-person-video2 ', 'text' => 'Lista de Docentes'],
                ['route' => 'ListaEstudiantes', 'icon' => 'bi bi-people', 'text' => 'Lista de Estudiantes'],
                ['route' => 'ListaExpositores', 'icon' => 'bi bi-person-video3', 'text' => 'Lista de Expositores'],
                ['route' => 'categorias.index', 'icon' => 'bi bi-tag-fill ', 'text' => 'Lista de Categorias'],
                ['route' => 'aportesLista', 'icon' => 'bi bi-wallet ', 'text' => 'Lista de Pagos'],
                ['route' => 'AsignarCurso', 'icon' => 'bi bi-person-lines-fill', 'text' => 'Asignación de Cursos'],
                ['route' => 'lista.cursos.congresos', 'icon' => 'bi bi-backpack2-fill', 'text' => 'Lista de Cursos/Congresos'],
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
                ['route' => 'lista.cursos.congresos', 'icon' => 'bi bi-backpack2-fill', 'text' => 'Lista de Cursos/Congresos'],
                ['route' => 'calendario', 'icon' => 'bi bi-calendar', 'text' => 'Calendario'],

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
                ['route' => 'lista.cursos.congresos', 'icon' => 'bi bi-backpack2-fill', 'text' => 'Lista de Cursos/Congresos'],
                ['route' => 'calendario', 'icon' => 'bi bi-calendar', 'text' => 'Calendario'],


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

            @yield('nav')

            <!-- Cerrar sesión -->
            <a href="{{ route('logout') }}" class="nav-link text-danger">
                <i class="bi bi-box-arrow-right"></i> <span>Salir</span>
            </a>
        </div>
    </div>

    <div class="content">
        <div class="header pt-md-1">
            <div class="container-fluid">
                <div class="header-body">
                    <style>

                        .navbar-main {
                            overflow: visible !important; /* Asegura que los elementos hijos no se corten */
                        }


                        .notification-dropdown .dropdown-menu {
                            position: absolute !important;
                            right: 0;
                            left: auto;
                            transform: translateY(10px); /* Ajuste opcional */
                            z-index: 1050; /* Asegura que esté por encima de otros elementos */
                        }

                        /* Navbar Estilos */
                        .navbar-main {
                            background: linear-gradient(145deg, rgba(26, 71, 137, 1) 40%, rgba(34, 77, 141, 1) 53%, rgba(255, 255, 255, 1) 53%);
                            width: 100%;
                            border: none;
                            position: relative;
                            overflow: hidden;
                            padding: 15px 20px;
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
                            }
                        }

                        /* Ajustes de logos */
                        .navbar-brand img {
                            max-height: 80px;
                            width: auto;
                        }

                        /* Logo derecho (Acceder) más pequeño */
                        .logo-acceder img {
                            max-height: 45px;
                        }

                        /* Dropdown de notificaciones */
                        .notification-dropdown .dropdown-menu {
                            background-color: #ffffff;
                            padding: 0;
                            border-radius: 0.25rem;
                            border: none;
                            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
                            min-width: 300px;
                            z-index: 1000;
                        }

                        .notification-dropdown .dropdown-item {
                            padding: 0.75rem 1rem;
                            color: rgb(0, 0, 0);
                            background-color: transparent;
                            border: none;
                        }

                        .notification-dropdown .dropdown-item:hover {
                            background-color: #9bf0ff;
                        }

                        .notification-dropdown small {
                            color: #055c9d !important;
                        }

                        .notification-dropdown .badge {
                            position: absolute;
                            top: -5px;
                            right: -5px;
                            font-size: 0.7rem;
                        }

                        .notification-dropdown .bell-container {
                            position: relative;
                            display: inline-block;
                        }

                        .notification-dropdown .nav-link {
                            color: rgb(243, 243, 243);
                        }

                        .notification-view-all {
                            display: block;
                            text-align: center;
                            padding: 0.5rem;
                            color: white;
                            background-color: #63becf;
                            text-decoration: none;
                        }

                        /* Responsividad: Ajustar la navbar en pantallas pequeñas */
                        @media (max-width: 768px) {
                            .navbar-main {
                                height: auto;
                                padding: 10px 15px;
                            }

                            .navbar-container {
                                flex-direction: column;
                                text-align: center;
                                gap: 10px;
                            }

                            .navbar-brand img {
                                max-height: 20px;
                            }

                            .logo-acceder img {
                                max-height: 10px;
                            }
                        }
                    </style>

                    <!-- Navbar -->
                    <nav id="navbar-main" class="navbar navbar-expand-lg navbar-light navbar-main">
                        <div class="container d-flex justify-content-between align-items-center">
                            <!-- Logo izquierdo -->
                            <a class="navbar-brand" href="{{ route('Inicio') }}">
                                <img src="{{ asset('../assets/img/logof.png') }}" alt="Logo Izquierdo" class="logo">
                            </a>

                            <div class="d-flex align-items-center">
                                <!-- Notificaciones -->
                                <div class="notification-dropdown me-4">
                                    <div class="dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            <div class="bell-container">
                                                <i class="fa fa-bell text-secondary"></i>

                                            </div>
                                        </a>

                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                                            @forelse (auth()->user()->notifications()->latest()->take(4)->get() as $notification)
                                                <li>
                                                    <a class="dropdown-item" href="#">
                                                        <p class="mb-0">{{ $notification->data['message'] }}</p>
                                                        <small>hace {{ $notification->created_at->diffForHumans(null, true) }}</small>
                                                    </a>
                                                </li>
                                            @empty
                                                <li><a class="dropdown-item text-center" href="#">No hay notificaciones</a></li>
                                            @endforelse

                                            <li><hr class="dropdown-divider m-0"></li>
                                            <li><a class="notification-view-all" href="#">Ver todas</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Logo derecho -->
                                <a class="logo-acceder" href="{{ route('Inicio') }}">
                                    <img src="{{ asset('../assets/img/Acceder.png') }}" alt="Logo Derecho" class="logo-acceder">
                                </a>
                            </div>
                        </div>
                    </nav>

                    @yield('contentup')
                </div>
            </div>
        </div>

        <div class="container-fluid mt-2">
                                @yield('content')
                                @yield('contentini')
        </div>
        <footer class="footer mt-4">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-6 text-center text-md-start text-muted">
                        &copy; <script>document.write(new Date().getFullYear());</script>
                        <a href="#" target="_blank">Fundación Educar para la Vida</a>.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <!-- Espacio para enlaces adicionales si los necesitas -->
                    </div>
                </div>
            </div>
        </footer>

    </div>

    <style>
        /* Estilos para el botón flotante */
        .floating-xp-button {
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s ease-in-out;
            visibility: hidden;
        }

        .floating-xp-button.show {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
        }

        .floating-xp-button .btn {
            transition: transform 0.3s ease;
        }

        .floating-xp-button .btn:hover {
            transform: scale(1.1) rotate(15deg);
        }

        /* Animación para el offcanvas */
        .offcanvas {
            transition: transform 0.3s ease-in-out !important;
        }

        /* Animación para los logros */
        .achievement-item {
            animation: slideIn 0.3s ease-out forwards;
            opacity: 0;
        }

        @keyframes slideIn {
            from {
                transform: translateX(20px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>

    <!-- Botón flotante de XP -->
    @auth
        <div class="position-fixed bottom-0 end-0 mb-4 me-4 floating-xp-button" style="z-index: 1050;">
            <button type="button" 
                    class="btn btn-primary rounded-circle p-3 shadow-lg" 
                    data-bs-toggle="offcanvas" 
                    data-bs-target="#xpOffcanvas" 
                    aria-controls="xpOffcanvas">
                <i class="bi bi-trophy-fill"></i>
            </button>
        </div>

        <!-- Offcanvas de XP -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="xpOffcanvas">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Mi Progreso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                @php
                    $user = auth()->user();
                    $inscripciones = $user->inscritos()->with(['cursos'])->get();
                    $xpHistory = \DB::table('xp_events')
                        ->where('users_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
                    $totalXP = $xpHistory->sum('xp');
                    $currentLevel = \App\Models\Level::getCurrentLevel($totalXP);
                @endphp

                <!-- Nivel y XP -->
                <div class="card mb-3 bg-primary text-white achievement-item" style="animation-delay: 0.1s">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Nivel {{ $currentLevel ? $currentLevel->level_number : 1 }}</h6>
                                <small>{{ $currentLevel ? $currentLevel->title : 'Principiante' }}</small>
                            </div>
                            <div class="text-end">
                                <h4 class="mb-0">{{ number_format($totalXP) }} XP</h4>
                                <small>Total acumulado</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Últimos logros -->
                <h6 class="mb-3 achievement-item" style="animation-delay: 0.2s">Últimos Logros</h6>
                @php
                    $unlockedAchievements = \App\Models\Achievement::whereHas('inscritos', function($query) use ($inscripciones) {
                        $query->whereIn('inscrito_id', $inscripciones->pluck('id'));
                    })->latest()->take(3)->get();
                @endphp

                @forelse($unlockedAchievements as $index => $achievement)
                    <div class="d-flex align-items-center mb-2 p-2 bg-light rounded achievement-item" 
                         style="animation-delay: {{ 0.3 + ($index * 0.1) }}s">
                        <div class="me-3">
                            <span class="h5 mb-0">{{ $achievement->icon }}</span>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $achievement->title }}</h6>
                            <small class="text-success">+{{ $achievement->xp_reward }} XP</small>
                        </div>
                    </div>
                @empty
                    <p class="text-muted achievement-item" style="animation-delay: 0.3s">
                        Aún no has desbloqueado ningún logro
                    </p>
                @endforelse

                <div class="mt-3 achievement-item" style="animation-delay: 0.5s">
                    <a href="{{ route('perfil.xp') }}" class="btn btn-primary w-100">
                        Ver todos mis logros
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="position-fixed bottom-0 end-0 mb-4 me-4 floating-xp-button" style="z-index: 1050;">
            <button type="button" 
                    class="btn btn-primary rounded-circle p-3 shadow-lg" 
                    data-bs-toggle="modal" 
                    data-bs-target="#registerModal">
                <i class="bi bi-trophy-fill"></i>
            </button>
        </div>

        <!-- Modal para usuarios no autenticados -->
        <div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">¡Únete a la aventura!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <i class="bi bi-trophy display-1 text-primary mb-3"></i>
                        <h4>Gana XP y Desbloquea Logros</h4>
                        <p>Regístrate para comenzar a ganar experiencia y desbloquear logros mientras aprendes.</p>
                        <div class="mt-4">
                            <a href="{{ route('signin') }}" class="btn btn-primary">Registrarme ahora</a>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary ms-2">Ya tengo cuenta</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endauth

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mostrar el botón después de un pequeño retraso
            setTimeout(() => {
                document.querySelectorAll('.floating-xp-button').forEach(button => {
                    button.classList.add('show');
                });
            }, 1000);

            // Variables para el scroll
            let lastScrollTop = 0;
            let isScrolling;

            // Función para ocultar/mostrar el botón al hacer scroll
            window.addEventListener('scroll', function() {
                clearTimeout(isScrolling);

                isScrolling = setTimeout(function() {
                    let currentScroll = window.pageYOffset || document.documentElement.scrollTop;
                    let button = document.querySelector('.floating-xp-button');

                    if (currentScroll > lastScrollTop) {
                        // Scrolling down
                        button.classList.remove('show');
                    } else {
                        // Scrolling up
                        button.classList.add('show');
                    }
                    lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
                }, 66);
            }, false);

            // Animación de los logros cuando se abre el offcanvas
            const xpOffcanvas = document.getElementById('xpOffcanvas');
            if (xpOffcanvas) {
                xpOffcanvas.addEventListener('show.bs.offcanvas', function () {
                    const items = document.querySelectorAll('.achievement-item');
                    items.forEach((item, index) => {
                        item.style.animationDelay = `${0.1 * (index + 1)}s`;
                        item.style.opacity = '0';
                        setTimeout(() => {
                            item.style.opacity = '1';
                        }, 100 * (index + 1));
                    });
                });
            }
        });
    </script>

    <!--   Core   -->
    <script src="{{ asset('./assets/js/plugins/jquery/dist/jquery.min.js') }}"></script>
    <!--   Optional JS   -->
    <script src="{{ asset('./assets/js/plugins/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('./assets/js/plugins/chart.js/dist/Chart.extension.js') }}"></script>
    <!--   Argon JS   -->
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js"></script>


<!-- Bootstrap CSS -->

<!-- Bootstrap Bundle con JavaScript -->

</body>

</html>
