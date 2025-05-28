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


    <footer class="bg-light border-top mt-5 shadow-sm">
        <div class="container py-5">
            <div class="row">
                <!-- Info de la Fundación -->
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="fw-semibold text-primary">Fundación Educar Para La Vida</h5>
                    <p class="text-muted small mb-0">
                        Inspirando el aprendizaje y el crecimiento personal a través de la educación.
                    </p>
                </div>

                <!-- Redes Sociales -->
                <div class="col-md-4 mb-4 mb-md-0 text-center">
                    <h6 class="fw-semibold text-dark">Síguenos en</h6>
                    <div class="d-flex justify-content-center gap-3 mt-3">
                        <a href="https://www.facebook.com/profile.php?id=100063510101095&mibextid=ZbWKwL" target="_blank"
                           class="btn btn-outline-secondary btn-sm rounded-circle">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://www.tiktok.com/@educarparalavida?_t=8fbFcMbWOGo&_r=1" target="_blank"
                           class="btn btn-outline-dark btn-sm rounded-circle">
                            <i class="bi bi-tiktok"></i>
                        </a>
                        <a href="https://instagram.com/fundeducarparalavida?igshid=MzRlODBiNWFlZA==" target="_blank"
                           class="btn btn-outline-danger btn-sm rounded-circle">
                            <i class="bi bi-instagram"></i>
                        </a>
                    </div>
                </div>

                <!-- Derechos -->
                <div class="col-md-4 text-center text-md-end">
                    <small class="text-muted">
                        &copy; {{ now()->year }} Fundación Educar para la Vida.<br class="d-md-none"> Todos los derechos reservados.
                    </small>
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
    /*Toggle dropdown list*/
    /*https://gist.github.com/slavapas/593e8e50cf4cc16ac972afcbad4f70c8*/

    var userMenuDiv = document.getElementById("userMenu");
    var userMenu = document.getElementById("userButton");

    var navMenuDiv = document.getElementById("nav-content");
    var navMenu = document.getElementById("nav-toggle");

    document.onclick = check;

    function check(e) {
        var target = (e && e.target) || (event && event.srcElement);

        //User Menu
        if (!checkParent(target, userMenuDiv)) {
            // click NOT on the menu
            if (checkParent(target, userMenu)) {
                // click on the link
                if (userMenuDiv.classList.contains("invisible")) {
                    userMenuDiv.classList.remove("invisible");
                } else { userMenuDiv.classList.add("invisible"); }
            } else {
                // click both outside link and outside menu, hide menu
                userMenuDiv.classList.add("invisible");
            }
        }

        //Nav Menu
        if (!checkParent(target, navMenuDiv)) {
            // click NOT on the menu
            if (checkParent(target, navMenu)) {
                // click on the link
                if (navMenuDiv.classList.contains("hidden")) {
                    navMenuDiv.classList.remove("hidden");
                } else { navMenuDiv.classList.add("hidden"); }
            } else {
                // click both outside link and outside menu, hide menu
                navMenuDiv.classList.add("hidden");
            }
        }

    }

    function checkParent(t, elm) {
        while (t.parentNode) {
            if (t == elm) { return true; }
            t = t.parentNode;
        }
        return false;
    }
</script>
</html>
