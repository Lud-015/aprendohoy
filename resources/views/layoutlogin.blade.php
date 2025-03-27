<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/Acceder.png') }}">
    <title>@yield('titulo')</title>
    <!-- Fonts and icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <link href="{{ asset('assets/css/font-awesome.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="{{ asset('assets/css/log.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets2/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets2/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets2/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets2/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets2/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets2/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos para la card con desenfoque */
        .card {
            width: 300px;
            height: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
            margin: auto;
            /* Centers the card horizontally */
            position: relative;
            /* Use relative or absolute positioning if needed */
        }


        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: blur(5px);
            /* Aplicar desenfoque */
            transition: filter 0.3s ease;
        }

        /* .card-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            text-align: center;
            border-radius: 10px;
        } */

        .card:hover .card-img {
            filter: blur(0);
            /* Remover desenfoque al pasar el ratón */
        }

        .bg-gray-transparent {
            background: rgba(108, 117, 125, 0.75);
            /* Gris (Bootstrap gray-600) con 75% de opacidad */
        }

        .rounded-input {
            border-radius: 20px !important;
        }
    </style>
</head>


<body>

    <header style="background: linear-gradient(145deg, rgb(255, 255, 255) 58%, rgb(255, 255, 255) 65%, rgb(16, 86, 152) 53%);">
        <div class="container d-flex align-items-center justify-content-between py-2">

            <!-- Contenedor del logo -->
            <div class="logo-container">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('assets/img/Acceder.png') }}" alt="Logo" style="height: 35px;">
                </a>
            </div>

            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light p-0">


                <!-- Contenido del navbar -->
                {{-- <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @if (auth()->user())
                            <li class="nav-item">
                                <a class="nav-link getstarted scrollto" href="{{ route('Inicio') }}">Ir a Inicio</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link getstarted scrollto" href="{{ route('login.signin') }}">Iniciar Sesión</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link getstarted scrollto" href="{{ route('signin') }}">Registrarse</a>
                            </li>
                        @endif
                    </ul>
                </div> --}}

                <!-- Logo adicional (visible en pantallas grandes) -->
                <div class="ms-4">
                    <img src="{{ asset('assets/img/logof.png') }}" alt="Logo adicional" class="img-fluid" style="height: 55px;">
                </div>
            </nav>

        </div>
    </header>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <section class="section"
        style="background: linear-gradient(rgba(20, 93, 160, 0.3), rgba(20, 93, 160, 0.3)), url('{{ asset('assets/img/bg2.png') }}'); background-size: cover; background-repeat: no-repeat; filter: brightness(0.8) contrast(1.2);">
        @yield('content')
    </section>

    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h3>Aprendo Hoy</h3>
                        <p>

                            Bolivia <br><br>
                            <strong>Celular:</strong><br>
                            (+591) 72087186 <br>
                            (+591) 4 4284295 <br>
                            (+591) 2 2433208 <br>
                            <strong>Correo Electrónico:</strong> contacto@educarparalavida.org.bo<br>
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Links Asociados</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a
                                    href="https://educarparalavida.org.bo/web/Inicio.html">Inicio</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a
                                    href="https://educarparalavida.org.bo/web/Quienes-somos.html">Quienes Somos</a>
                            </li>
                            <li><i class="bx bx-chevron-right"></i> <a
                                    href="https://educarparalavida.org.bo/web/Proyectos-y-servicios.html">Servicios</a>
                            </li>
                            {{-- <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li> --}}
                        </ul>
                    </div>

                    {{-- <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Our Services</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
                        </ul>
                    </div> --}}

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Nuestras Redes Sociales</h4>
                        {{-- <p>Cras fermentum odio eu feugiat lide par naso tierra videa magna derita valies</p> --}}
                        <div class="social-links mt-3">
                            <a href="https://x.com/FUNDVIDA2" class="twitter"><i class="bx bxl-twitter"></i></a>
                            <a href="https://www.facebook.com/profile.php?id=100063510101095" class="facebook"><i
                                    class="bx bxl-facebook"></i></a>
                            <a href="https://www.instagram.com/fundeducarparalavida/" class="instagram"><i
                                    class="bx bxl-instagram"></i></a>
                            <a href="https://api.whatsapp.com/send?phone=%3C+59172087186%3E" class="whatsapp"><i
                                    class="bx bxl-whatsapp"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="container py-4">
            <div class="copyright">
                <script>
                    document.write("&copy; " + new Date().getFullYear() +
                        " <a href='' target='_blank'>Fundación educar para la vida</a>.");
                </script>
            </div>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/free-bootstrap-app-landing-page-template/ -->
                {{-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> --}}
            </div>
        </div>
    </footer><!-- End Footer -->

    <!-- Core JS Files -->
    @if (session('success'))
        <script>
            Swal.fire({
                title: "¡Éxito!",
                text: "{{ session('success') }}",
                icon: "success",
                confirmButtonText: "OK"
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                title: "Error",
                text: "{{ session('error') }}",
                icon: "error",
                confirmButtonText: "OK"
            });
        </script>
    @endif
    <script>
        function togglePasswordVisibility(button) {
            const passwordField = document.getElementById('password');
            const icon = button.querySelector('i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
