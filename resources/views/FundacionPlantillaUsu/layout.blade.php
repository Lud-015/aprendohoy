<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Inicio')</title>
    <meta name="description" content="@yield('description', 'Fundación Educar Para La Vida')">

    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=atma:600" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('./resources/css/styles3.css') }}">

    <!-- External Scripts -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-light font-sans" style="line-height: 1.5;">

    @yield('nav2')
    @yield('container')

    <!-- Alert Scripts -->
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

    <!-- Main Content -->
    <div class="container-fluid mt-2">
        @yield('contentini')
    </div>

    <!-- Footer -->
    {{-- <footer class="bg-white border-top mt-5 py-5">
        <div class="container">
            <div class="row gy-4 justify-content-between">
                <!-- Contact Information -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-primary fw-bold mb-4 section-title">Fundación Educar Para La Vida</h5>
                    <ul class="list-unstyled">
                        <li class="contact-item mb-3">
                            <div class="icon-box">
                                <i class="bi bi-geo-alt text-primary"></i>
                            </div>
                            <span>Bolivia</span>
                        </li>
                        <li class="contact-item mb-3">
                            <div class="icon-box">
                                <i class="bi bi-telephone text-primary"></i>
                            </div>
                            <span>+591 72087186</span>
                        </li>
                        <li class="contact-item">
                            <div class="icon-box">
                                <i class="bi bi-envelope text-primary"></i>
                            </div>
                            <span>contacto@educarparalavida.org.bo</span>
                        </li>
                    </ul>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-primary fw-bold mb-4 section-title">Enlaces Rápidos</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <a href="https://educarparalavida.org.bo/web/Inicio.html" class="footer-link">
                                <i class="bi bi-chevron-right me-2"></i>
                                <span>Inicio</span>
                            </a>
                        </li>
                        <li class="mb-3">
                            <a href="https://educarparalavida.org.bo/web/Quienes-somos.html" class="footer-link">
                                <i class="bi bi-chevron-right me-2"></i>
                                <span>Quiénes Somos</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://educarparalavida.org.bo/web/Proyectos-y-servicios.html" class="footer-link">
                                <i class="bi bi-chevron-right me-2"></i>
                                <span>Servicios</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Social Media -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-primary fw-bold mb-4 section-title">Síguenos en</h5>
                    <div class="d-flex gap-3">
                        <a href="https://www.facebook.com/profile.php?id=100063510101095" class="social-btn" target="_blank" aria-label="Facebook">
                            <i class="bi bi-facebook fs-5"></i>
                        </a>
                        <a href="https://www.instagram.com/fundeducarparalavida/" class="social-btn" target="_blank" aria-label="Instagram">
                            <i class="bi bi-instagram fs-5"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?phone=59172087186" class="social-btn" target="_blank" aria-label="WhatsApp">
                            <i class="bi bi-whatsapp fs-5"></i>
                        </a>
                        <a href="https://x.com/FUNDVIDA2" class="social-btn" target="_blank" aria-label="Twitter">
                            <i class="bi bi-twitter-x fs-5"></i>
                        </a>
                    </div>
                </div>
            </div>

            <hr class="my-5 opacity-25">

            <!-- Copyright -->
            <div class="text-center">
                <p class="text-muted mb-0">
                    &copy; <span id="current-year"></span>
                    <span class="text-primary">Fundación Educar para la Vida</span>.
                    Todos los derechos reservados.
                </p>
            </div>
        </div>
    </footer> --}}

    <!-- Optimized Styles -->
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6f42c1;
            --accent-color: #20c997;
            --hover-color: #0b5ed7;
        }

        /* Footer Styles */
        .section-title {
            position: relative;
            padding-bottom: 10px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 2px;
            background-color: var(--secondary-color);
        }

        .contact-item {
            display: flex;
            align-items: center;
            color: #6c757d;
        }

        .icon-box {
            width: 35px;
            height: 35px;
            background-color: #f8f9fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            transition: all 0.3s ease;
        }

        .footer-link {
            color: #6c757d;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .footer-link:hover {
            color: var(--secondary-color);
            transform: translateX(5px);
        }

        .social-btn {
            width: 45px;
            height: 45px;
            background-color: #f8f9fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-btn:hover {
            background-color: var(--secondary-color);
            color: white;
            transform: translateY(-3px);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .social-btn {
                width: 40px;
                height: 40px;
            }
        }
    </style>

<footer id="footer">

    <style>
        #footer {
            background-color: #2c3e50;
            color: #ffffff;
            padding: 40px 0 20px 0;
        }

        .footer-top {
            padding-bottom: 30px;
        }

        .footer-contact h3 {
            color: #3498db;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .footer-contact p {
            line-height: 24px;
            margin-bottom: 0;
        }

        .footer-links h4 {
            color: #ffffff;
            margin-bottom: 20px;
            font-size: 18px;
        }

        .footer-links ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links ul li {
            padding: 8px 0;
            border-bottom: 1px solid #34495e;
        }

        .footer-links ul li:last-child {
            border-bottom: none;
        }

        .footer-links ul a {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links ul a:hover {
            color: #3498db;
        }

        .footer-links ul i {
            color: #3498db;
            margin-right: 8px;
        }

        .social-links a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background: #34495e;
            color: #ffffff;
            text-align: center;
            line-height: 40px;
            margin-right: 10px;
            border-radius: 50%;
            transition: all 0.3s;
            text-decoration: none;
        }

        .social-links a:hover {
            background: #3498db;
            transform: translateY(-2px);
        }

        .copyright {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #34495e;
            color: #bdc3c7;
        }

        .copyright a {
            color: #3498db;
            text-decoration: none;
        }

        .copyright a:hover {
            text-decoration: underline;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .footer-contact, .footer-links {
                margin-bottom: 30px;
            }
        }
    </style>
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 footer-contact mb-4 mb-lg-0">
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

                <div class="col-lg-3 col-md-6 footer-links mb-4 mb-lg-0">
                    <h4>Links Asociados</h4>
                    <ul>
                        <li><i class="fa fa-link"></i> <a
                                href="https://educarparalavida.org.bo/web/Inicio.html">Web Principal</a></li>
                        <li><i class="fa fa-users"></i> <a
                                href="https://educarparalavida.org.bo/web/Quienes-somos.html">Quienes Somos</a>
                        </li>
                        <li><i class="bi bi-server"></i> <a
                                href="https://educarparalavida.org.bo/web/Proyectos-y-servicios.html">Servicios</a>
                        </li>
                    </ul>
                </div>

                <!-- Spacer column for better layout -->
                <div class="col-lg-3 col-md-6 d-none d-lg-block"></div>

                <div class="col-lg-3 col-md-6 footer-links">
                    <h4>Nuestras Redes Sociales</h4>
                    <div class="social-links mt-3">
                        <a href="https://x.com/FUNDVIDA2" class="twitter" aria-label="Twitter"><i class="bi bi-twitter"></i></a>
                        <a href="https://www.facebook.com/profile.php?id=100063510101095" class="facebook" aria-label="Facebook"><i
                                class="bi bi-facebook"></i></a>
                        <a href="https://www.instagram.com/fundeducarparalavida/" class="instagram" aria-label="Instagram"><i
                                class="bi bi-instagram"></i></a>
                        <a href="https://api.whatsapp.com/send?phone=%3C+59172087186%3E" class="whatsapp" aria-label="WhatsApp"><i
                                class="bi bi-whatsapp"></i></a>
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
    </div>
</footer>

    @include('botman.tinker')
    {{-- @include('components.achievements') --}}

    <!-- Essential Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Initialize current year -->
    <script>
        document.getElementById('current-year').textContent = new Date().getFullYear();
    </script>

    @stack('scripts')

</body>
</html>