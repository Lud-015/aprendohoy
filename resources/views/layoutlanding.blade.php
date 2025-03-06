<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Detalle del Curso </title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    @php
        use Carbon\Carbon;
    @endphp
    <!-- Favicons -->
    <link href="{{ asset('assets/img/Acceder.png') }}" rel="icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="assets2/vendor/aos/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <link href="{{asset('assets2/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('assets2/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets2/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets2/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets2/css/style.css')}}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Detectar cuando cualquier modal se oculta
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('hidden.bs.modal', function () {
                // Buscar y eliminar backdrop sobrante
                document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());

                // Asegurar que el body no quede bloqueado
                document.body.classList.remove('modal-open');
                document.body.style.overflow = 'auto'; // Habilitar scroll si estaba bloqueado
                document.body.style.paddingRight = ''; // Corregir desplazamiento
            });
        });
    });
</script>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top  header-transparent ">
        <div class="container d-flex align-items-center justify-content-between">

            <div class="">
                <a href="index.html"><img src="{{asset('assets/img/Acceder.png')}}" alt="" style=" height: 50px;"></a>
            </div>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="{{ route(name: 'home') }}">Pagina Principal</a></li>

                    @if (auth()->user())
                        <li><a class="getstarted scrollto" href="{{ route('Inicio') }}">Ir a Inicio</a></li>
                    @else
                        <li><a class="getstarted scrollto" href="{{ route('login.signin') }}">Iniciar Sesión</a></li>
                        <li><a class="getstarted scrollto" href="{{ route('signin') }}">Registrarse</a></li>
                    @endif
                    <li class="">
                        <a href="index.html"><img src="{{asset('assets/img/logof.png')}}" alt="" class="img-fluid"
                                style=" height: 55px;"></a>
                    </li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">

        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-lg-flex flex-lg-column justify-content-center align-items-stretch pt-5 pt-lg-0 order-2 order-lg-1"
                    data-aos="fade-up">
                    <div>
                        <h3>@if ($cursos->tipo == 'curso')
                            Curso: {{$cursos->nombreCurso}}
                        @else
                            Congreso: {{$cursos->nombreCurso}}
                        @endif</h3>
                        <h2>{{$cursos->descripcionC}}</h2>
                        <h2>📅 {{ \Carbon\Carbon::parse($cursos->fecha_ini)->format('d M Y') }} </h2>

                        @if (auth()->user() != null)

                       <form action="{{ route('inscribirse_congreso', ['id' => $cursos->id]) }}" method="POST">
    @csrf
    <button type="submit" class="download-btn">
        <i class="bx bxl-discourse"></i> Inscribirse
    </button>
</form>

                        @else
                        <a href="#" class="download-btn" id="btn-inscribirse">
                            <i class="bx bxl-discourse"></i> Inscribirse
                        </a>
                        @endif


                    </div>
                </div>
                <div class="col-lg-6 d-lg-flex flex-lg-column align-items-stretch order-1 order-lg-2 hero-img"
                    data-aos="fade-up">

                    @if (!empty($cursos->temas) && is_iterable($cursos->temas))
                    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($cursos->temas as $key => $tema)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $tema->imagen) }}" class="d-block w-100">
                            </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                    @else
                    <p>No hay imágenes disponibles.</p>
                    @endif
                </div>
            </div>
        </div>

    </section><!-- End Hero -->



    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

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


    <!-- Vendor JS Files -->
    <script src="{{asset('assets2/vendor/aos/aos.js')}}"></script>
    <script src="{{asset('assets2/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets2/vendor/glightbox/js/glightbox.min.js')}}"></script>
    <script src="{{asset('assets2/vendor/swiper/swiper-bundle.min.js')}}"></script>
    <script src="{{asset("assets2/vendor/php-email-form/validate.js")}}"></script>
<!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Template Main JS File -->
    <script src="assets2/js/main.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Escuchar el evento cuando un modal se oculta
            document.querySelectorAll('.modal').forEach(modal => {
                modal.addEventListener('hidden.bs.modal', function () {
                    // Eliminar backdrop manualmente si aún existe
                    document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
                    document.body.classList.remove('modal-open'); // Eliminar clase modal-open
                    document.body.style.paddingRight = ''; // Corregir posibles desplazamientos
                });
            });
        });
    </script>

<script>
    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('modal-backdrop')) {
            document.querySelectorAll('.modal.show').forEach(modal => {
                let modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) modalInstance.hide();
            });
        }
    });
</script>
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
                    " <a href='' target='_blank'>Fundación para educar la vida</a>.");
            </script>
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/free-bootstrap-app-landing-page-template/ -->
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </div>
</footer><!-- End Footer -->

<script>
    document.getElementById("btn-inscribirse").addEventListener("click", function (event) {
        event.preventDefault(); // Evita que el enlace navegue

        // Simulación de autenticación (reemplaza esto con tu lógica real)
        let usuarioAutenticado = false; // Cambiar a `true` si el usuario ha iniciado sesión

        if (!usuarioAutenticado) {
            Swal.fire({
                title: "¡Inicia sesión o crea una cuenta!",
                text: "Para inscribirte en un congreso, necesitas estar autenticado.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Iniciar Sesión",
                cancelButtonText: "Crear Cuenta",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/login"; // Redirigir a iniciar sesión
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    window.location.href = "/signin"; // Redirigir a registro
                }
            });
        } else {
            // Si el usuario está autenticado, redirigir a la inscripción
            window.location.href = "/inscribirse"; // Cambia esto por la ruta real de inscripción
        }
    });
</script>
@include('botman.tinker')


</body>

</html>
