<!DOCTYPE html>
<html lang="es" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('titulo', 'Iniciar sesión')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/Acceder.png') }}">

    <!-- Bootstrap 5.3.2 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom Fonts & Styles -->
    <link href="{{ asset('assets/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('assets2/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets2/css/style.css') }}" rel="stylesheet">

    <!-- AOS + Swiper + Glightbox -->
    <link href="{{ asset('assets2/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets2/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets2/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(rgba(20, 93, 160, 0.3), rgba(20, 93, 160, 0.3)),
                        url('{{ asset('assets/img/bg2.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            filter: brightness(0.9) contrast(1.1);
            min-height: 100vh;
        }

        .login-card {
            max-width: 400px;
            margin: 6rem auto;
            padding: 2rem;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            border-radius: 50px;
        }

        .btn-login {
            border-radius: 50px;
        }

        footer {
            background: #f8f9fa;
            margin-top: 5rem;
            padding: 2rem 0;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header class="bg-white shadow-sm position-relative">
        <!-- Blue diagonal cut -->
        <div class="diagonal-cut"></div>

        <div class="container d-flex align-items-center justify-content-between py-3">
            <!-- Logo principal -->
            <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
                <img src="{{ asset('assets/img/Acceder.png') }}" alt="Logo" style="height: 35px;">
            </a>

            <!-- Botones -->
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('home') }}" class="btn btn-outline-primary rounded-pill px-4">Ir al Inicio</a>
                <a href="{{ route('signin') }}" class="btn btn-primary rounded-pill px-4">Crear cuenta</a>
            </div>

            <!-- Logo adicional -->
            <img src="{{ asset('assets/img/logof.png') }}" alt="Logo Fundación" style="height: 55px;">
        </div>
    </header>

    <!-- Add this CSS to your stylesheet -->
    <style>
        .diagonal-cut {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, transparent 60%, #075092 60%);
            z-index: 0;
            pointer-events: none;
        }

        .container {
            position: relative;
            z-index: 1;
        }
    </style>



    <!-- Login Card -->
    <main class="d-flex align-items-center justify-content-center">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row text-center text-md-start">
                <div class="col-md-4 mb-3">
                    <h5>Aprendo Hoy</h5>
                    <p>Bolivia<br>+591 72087186<br>contacto@educarparalavida.org.bo</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Enlaces</h5>
                    <ul class="list-unstyled">
                        <li><a href="https://educarparalavida.org.bo/web/Inicio.html" class="text-decoration-none">Inicio</a></li>
                        <li><a href="https://educarparalavida.org.bo/web/Quienes-somos.html" class="text-decoration-none">Quiénes somos</a></li>
                        <li><a href="https://educarparalavida.org.bo/web/Proyectos-y-servicios.html" class="text-decoration-none">Servicios</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Síguenos</h5>
                    <a href="https://x.com/FUNDVIDA2" class="me-2 text-dark"><i class="bi bi-twitter"></i></a>
                    <a href="https://www.facebook.com/profile.php?id=100063510101095" class="me-2 text-dark"><i class="bi bi-facebook"></i></a>
                    <a href="https://www.instagram.com/fundeducarparalavida/" class="me-2 text-dark"><i class="bi bi-instagram"></i></a>
                    <a href="https://api.whatsapp.com/send?phone=%3C+59172087186%3E" class="text-dark"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>

            <div class="text-center pt-3 border-top mt-3">
                &copy; <script>document.write(new Date().getFullYear())</script> Fundación Educar para la Vida
            </div>
        </div>
    </footer>

    <!-- JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function togglePasswordVisibility(button) {
            const input = button.previousElementSibling;
            const icon = button.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3085d6'
        });
        @endif

        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            confirmButtonColor: '#d33'
        });
        @endif
    </script>
</body>
</html>
