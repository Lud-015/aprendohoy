<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inicio</title>
    <meta name="description" content="description here">
    <meta name="keywords" content="keywords,here">
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons (reemplaza Font Awesome) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js" integrity="sha256-XF29CBwU1MWLaGEnsELogU6Y6rcc5nCkhhx89nFMIDQ=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Atma:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=atma:600" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('./resources/css/styles3.css') }}">
</head>

<body class="bg-light font-sans" style="line-height: 1.5; letter-spacing: normal;">

    @yield('nav2')
    @yield('container')

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: `<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>`,
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif


    <footer class="bg-white border-top mt-5 py-5">
        <div class="container">
            <div class="row gy-4 justify-content-between">
                <!-- Información de Contacto -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-primary fw-bold mb-4 position-relative pb-2">Fundación Educar Para La Vida</h5>
                    <ul class="list-unstyled">
                        <li class="d-flex align-items-center mb-3">
                            <div class="icon-box bg-light rounded-circle p-2 me-3">
                                <i class="bi bi-geo-alt text-primary"></i>
                            </div>
                            <span class="text-muted">Bolivia</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <div class="icon-box bg-light rounded-circle p-2 me-3">
                                <i class="bi bi-telephone text-primary"></i>
                            </div>
                            <span class="text-muted">+591 72087186</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="icon-box bg-light rounded-circle p-2 me-3">
                                <i class="bi bi-envelope text-primary"></i>
                            </div>
                            <span class="text-muted">contacto@educarparalavida.org.bo</span>
                        </li>
                    </ul>
                </div>

                <!-- Enlaces Rápidos -->
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-primary fw-bold mb-4 position-relative pb-2">Enlaces Rápidos</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <a href="https://educarparalavida.org.bo/web/Inicio.html"
                               class="text-decoration-none text-muted d-flex align-items-center footer-link">
                                <i class="bi bi-chevron-right me-2"></i>
                                <span>Inicio</span>
                            </a>
                        </li>
                        <li class="mb-3">
                            <a href="https://educarparalavida.org.bo/web/Quienes-somos.html"
                               class="text-decoration-none text-muted d-flex align-items-center footer-link">
                                <i class="bi bi-chevron-right me-2"></i>
                                <span>Quiénes Somos</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://educarparalavida.org.bo/web/Proyectos-y-servicios.html"
                               class="text-decoration-none text-muted d-flex align-items-center footer-link">
                                <i class="bi bi-chevron-right me-2"></i>
                                <span>Servicios</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Redes Sociales -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-primary fw-bold mb-4 position-relative pb-2">Síguenos en</h5>
                    <div class="d-flex gap-3">
                        <a href="https://www.facebook.com/profile.php?id=100063510101095"
                           class="btn btn-light rounded-circle p-2 footer-social"
                           target="_blank">
                            <i class="bi bi-facebook fs-5"></i>
                        </a>
                        <a href="https://www.instagram.com/fundeducarparalavida/"
                           class="btn btn-light rounded-circle p-2 footer-social"
                           target="_blank">
                            <i class="bi bi-instagram fs-5"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?phone=59172087186"
                           class="btn btn-light rounded-circle p-2 footer-social"
                           target="_blank">
                            <i class="bi bi-whatsapp fs-5"></i>
                        </a>
                        <a href="https://x.com/FUNDVIDA2"
                           class="btn btn-light rounded-circle p-2 footer-social"
                           target="_blank">
                            <i class="bi bi-twitter-x fs-5"></i>
                        </a>
                    </div>
                </div>
            </div>

            <hr class="my-5" style="background-color: var(--accent-color); opacity: 0.1;">

            <!-- Copyright -->
            <div class="row">
                <div class="col-12 text-center">
                    <p class="text-muted mb-0">
                        &copy; <script>document.write(new Date().getFullYear())</script>
                        <span class="text-primary">Fundación Educar para la Vida</span>.
                        Todos los derechos reservados.
                    </p>
                </div>
            </div>
        </div>
    </footer>


    <style>
        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            transform: translateY(-3px);
        }

        .facebook:hover {
            background-color: #1877f2;
        }

        .instagram:hover {
            background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
        }

        .tiktok:hover {
            background-color: #000000;
        }

        .email:hover {
            background-color: #d44638;
        }

        .social-icon:hover img,
        .social-icon:hover svg {
            filter: brightness(0) invert(1);
        }

        .hover-link:hover {
            color: var(--hover-color) !important;
            transition: color 0.3s ease;
        }

        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background-color: var(--hover-color);
            color: white;
            transform: translateY(-3px);
        }

        footer {
            background-color: #f8f9fa;
        }

        footer h5 {
            position: relative;
            padding-bottom: 10px;
        }

        footer h5::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 2px;
            background-color: var(--accent-color);
        }

        .icon-box {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .footer-link {
            transition: all 0.3s ease;
        }

        .footer-link:hover {
            color: var(--secondary-color) !important;
            transform: translateX(5px);
        }

        .footer-link:hover i {
            color: var(--secondary-color);
        }

        .footer-social {
            transition: all 0.3s ease;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .footer-social:hover {
            background-color: var(--secondary-color) !important;
            color: white !important;
            transform: translateY(-3px);
        }

        .position-relative.pb-2::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 2px;
            background-color: var(--secondary-color);
        }

        footer .text-primary {
            color: var(--primary-color) !important;
        }

        footer .bi {
            transition: all 0.3s ease;
        }
    </style>

    <script>
        document.getElementById('current-year').textContent = new Date().getFullYear();
    </script>

<!-- Agrega esto en tu CSS personalizado para los efectos hover -->
<style>
    .hover-primary:hover { color: #0d6efd !important; }
    .hover-dark:hover { color: #212529 !important; }
    .hover-pink:hover { color: #d63384 !important; }
</style>
    @include('botman.tinker')

    <!-- Incluir el componente de XP -->
    @php
        if (auth()->check()) {
            $user = auth()->user();
            $inscripciones = $user->inscritos()->with(['cursos'])->get();
            $xpHistory = \DB::table('xp_events')
                ->where('users_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
            $totalXP = $xpHistory->sum('xp');
            $currentLevel = \App\Models\Level::getCurrentLevel($totalXP);
            $nextLevel = \App\Models\Level::getNextLevel($currentLevel ? $currentLevel->level_number : 1);

            // Calcular el progreso al siguiente nivel
            if ($currentLevel && $nextLevel) {
                $xpForCurrentLevel = $currentLevel->xp_required;
                $xpForNextLevel = $nextLevel->xp_required;
                $xpProgress = $totalXP - $xpForCurrentLevel;
                $xpNeeded = $xpForNextLevel - $xpForCurrentLevel;
                $progressToNext = ($xpNeeded > 0) ? min(100, ($xpProgress / $xpNeeded) * 100) : 0;
            } else {
                $progressToNext = 0;
            }

            $unlockedAchievements = \App\Models\Achievement::whereHas('inscritos', function($query) use ($inscripciones) {
                $query->whereIn('inscrito_id', $inscripciones->pluck('id'));
            })->latest()->take(3)->get();
        }
    @endphp

    @include('components.xp-system')

</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener referencias a los elementos
        const userMenuDiv = document.getElementById("userMenu");
        const userMenu = document.getElementById("userButton");
        const navMenuDiv = document.getElementById("nav-content");
        const navMenu = document.getElementById("nav-toggle");

        // Solo agregar el evento click si los elementos existen
        if (userMenuDiv && userMenu && navMenuDiv && navMenu) {
            document.onclick = function(e) {
                const target = (e && e.target) || (event && event.srcElement);

                // User Menu
                if (userMenuDiv && !checkParent(target, userMenuDiv)) {
                    if (checkParent(target, userMenu)) {
                        if (userMenuDiv.classList.contains("invisible")) {
                            userMenuDiv.classList.remove("invisible");
                        } else {
                            userMenuDiv.classList.add("invisible");
                        }
                    } else {
                        userMenuDiv.classList.add("invisible");
                    }
                }

                // Nav Menu
                if (navMenuDiv && !checkParent(target, navMenuDiv)) {
                    if (checkParent(target, navMenu)) {
                        if (navMenuDiv.classList.contains("hidden")) {
                            navMenuDiv.classList.remove("hidden");
                        } else {
                            navMenuDiv.classList.add("hidden");
                        }
                    } else {
                        navMenuDiv.classList.add("hidden");
                    }
                }
            };
        }

        function checkParent(t, elm) {
            while(t.parentNode) {
                if(t == elm) return true;
                t = t.parentNode;
            }
            return false;
        }
    });
</script>
</html>
