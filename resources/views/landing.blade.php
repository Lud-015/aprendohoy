<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Aprendo Hoy</title>
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

    <link href="assets2/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets2/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets2/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets2/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets2/css/style.css" rel="stylesheet">


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
                <a href="index.html"><img src="assets/img/Acceder.png" alt="" style=" height: 35px;"></a>
            </div>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="#hero">Inicio</a></li>
                    <li><a class="nav-link scrollto" href="#features">Información</a></li>


                    <li><a class="nav-link scrollto" href="#contact">Contacto</a></li>
                    @if (auth()->user())
                        <li><a class="getstarted scrollto" href="{{ route('Inicio') }}">Ir a Inicio</a></li>
                    @else
                        <li><a class="getstarted scrollto" href="{{ route('login.signin') }}">Iniciar Sesión</a></li>
                        <li><a class="getstarted scrollto" href="{{ route('signin') }}">Registrarse</a></li>
                    @endif
                    <li class="">
                        <a href="index.html"><img src="assets/img/logof.png" alt="" class="img-fluid"
                                style=" height: 55px;"></a>
                    </li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center" >

        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-lg-flex flex-lg-column justify-content-center align-items-stretch pt-5 pt-lg-0 order-2 order-lg-1"
                    data-aos="fade-up">
                    <div>
                        <h1>"Aprende a tu
                            ritmo, donde quieras y cuando quieras. ¡Tu futuro comienza aquí!"</h1>
                        {{-- <h2>Lorem ipsum dolor sit amet, tota senserit percipitur ius ut, usu et fastidii forensibus voluptatibus. His ei nihil feugait</h2> --}}
                        <a href="{{route('lista.cursos.congresos')}}" class="download-btn"><i class="bx bxl-graphql"></i> Ir a la lista de Cursos</a>
                    </div>
                </div>
                <div class="col-lg-6 d-lg-flex flex-lg-column align-items-stretch order-1 order-lg-2 hero-img"
                    data-aos="fade-up">
                    <img src="assets2/img/hero-img.png" class="img-fluid" alt="">
                </div>
            </div>
        </div>

    </section><!-- End Hero -->

    <main id="main">

        <section id="congress-list" class="testimonials section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Últimos Congresos</h2>
                    <p>Explora los congresos próximos y regístrate para participar en eventos de alto impacto.</p>
                </div>

                <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
                    <div class="swiper-wrapper">
                        @forelse ($congresos as $congreso)
                            @php
                                $fecha_ini = Carbon::parse($congreso->fecha_ini);
                                $fecha_fin = Carbon::parse($congreso->fecha_fin);
                            @endphp
                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <img src="{{ asset('assets2/img/congress.jpg') }}" class="congress-img"
                                        style="
                                            width: 100%;
                                            height: 150px;
                                            object-fit: cover;
                                            border-radius: 10px;
                                            margin-bottom: 15px;
                                        "
                                        alt="Congreso Innovatech 2024">
                                    <h3>{{ $congreso->nombreCurso }}</h3>
                                    @if ($fecha_ini->month == $fecha_fin->month)
                                        <h4>
                                            📅 {{ $fecha_ini->format('d') }} - {{ $fecha_fin->format('d') }} de
                                            {{ $fecha_ini->locale('es')->isoFormat('MMMM') }}
                                        </h4>
                                    @else
                                        <h4>
                                            📅 {{ $fecha_ini->format('d') }} de
                                            {{ $fecha_ini->locale('es')->isoFormat('MMMM') }} -
                                            {{ $fecha_fin->format('d') }} de
                                            {{ $fecha_fin->locale('es')->isoFormat('MMMM') }}
                                        </h4>
                                    @endif
                                    <p>
                                        {{ $congreso->descripcionC }}
                                    </p>
                                    <!-- Botón que abre el Modal, enviando el id del congreso -->
                                    <a href="{{ route('congreso.detalle', $congreso->id) }}">
                                        Inscribirse
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="section-title">
                                <h2>No hay Congresos Disponibles</h2>
                            </div>
                        @endforelse
                    </div>
                    <div class="swiper-pagination"></div>
                </div>

            </div>
        </section>

        <section id="cursos" class="testimonials section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Ultimos Cursos</h2>
                    <p>Descubre tu potencial, aprende online.</p>
                </div>

                <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
                    <div class="swiper-wrapper ">
                        @forelse ($cursos as $curso)
                            @php
                                $fecha_ini = Carbon::parse($curso->fecha_ini);
                                $fecha_fin = Carbon::parse($curso->fecha_fin);
                            @endphp
                            <div class="swiper-slide  ">
                                <div class="testimonial-item">
                                    <img src="{{ asset('assets/img/bg2.png') }}" class="congress-img"
                                        style="
                                width: 100%;
                                height: 150px;
                                object-fit: cover;
                                border-radius: 10px;
                                margin-bottom: 15px;
                            "
                                        alt="Congreso Innovatech 2024">
                                    <h3>{{ $curso->nombreCurso }}</h3>
                                    @if ($fecha_ini->month == $fecha_fin->month)
                                        <h4>
                                            📅 {{ $fecha_ini->format('d') }} - {{ $fecha_fin->format('d') }} de
                                            {{ $fecha_ini->locale('es')->isoFormat('MMMM') }}
                                        </h4>
                                    @else
                                        <h4>
                                            📅 {{ $fecha_ini->format('d') }} de
                                            {{ $fecha_ini->locale('es')->isoFormat('MMMM') }} -
                                            {{ $fecha_fin->format('d') }} de
                                            {{ $fecha_fin->locale('es')->isoFormat('MMMM') }}
                                        </h4>
                                    @endif
                                    <p>
                                        {{ $curso->descripcionC }}
                                    </p>
                                    <!-- Botón que abre el Modal, enviando el id del congreso -->
                                    <a href="{{ route('congreso.detalle', $curso->id) }}">
                                    Inscribirse
                                    </a>


                                </div>
                            </div>


                    </div>


                    @empty
                    <div class="section-title">
                        <h2>No hay Congresos Disponibles</h2>
                    </div>
                    @endforelse


                </div>

            </div>
        </section>

               <!-- ======= App Features Section ======= -->
               <section id="features" class="features">
                <div class="container">

                    <div class="section-title">
                        <h2>Sistema de Cursos</h2>
                        <p>Nuestro sistema de cursos está diseñado para satisfacer tus necesidades educativas, ofreciendo
                            una experiencia de aprendizaje única y accesible para todos. Con características avanzadas y un
                            enfoque en la interactividad y la seguridad, estamos aquí para ayudarte a alcanzar tus metas
                            académicas y profesionales.</p>
                    </div>

                    <div class="row no-gutters">
                        <div class="col-xl-7 d-flex align-items-stretch order-2 order-lg-1">
                            <div class="content d-flex flex-column justify-content-center">
                                <div class="row">
                                    <div class="col-md-6 icon-box" data-aos="fade-up">
                                        <i class="bx bx-receipt"></i>
                                        <h4>Evaluativo</h4>
                                        <p>Proporciona una evaluación detallada y personalizada para cada estudiante,
                                            ayudándolos a comprender mejor sus fortalezas y áreas de mejora.</p>
                                    </div>
                                    <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                                        <i class="bx bx-cube-alt"></i>
                                        <h4>Interfaz</h4>
                                        <p>Ofrece una interfaz intuitiva y fácil de usar que facilita la navegación y el
                                            acceso a todos los recursos educativos disponibles.</p>
                                    </div>
                                    <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                                        <i class="bx bx-images"></i>
                                        <h4>Recursos Eduactivos</h4>
                                        <p>Accede a una amplia variedad de recursos educativos, incluyendo videos, lecturas,
                                            y ejercicios prácticos diseñados por expertos en la materia.</p>
                                    </div>
                                    <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="300">
                                        <i class="bx bx-shield"></i>
                                        <h4>Seguridad</h4>
                                        <p>Garantizamos la máxima seguridad de tus datos personales y académicos, utilizando
                                            las últimas tecnologías en cifrado y protección de información.</p>
                                    </div>
                                    <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="400">
                                        <i class="bx bx-atom"></i>
                                        <h4>Interactividad</h4>
                                        <p>Fomenta la interactividad a través de foros de discusión, sesiones en vivo, y
                                            actividades colaborativas que enriquecen el proceso de aprendizaje.</p>
                                    </div>
                                    <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="500">
                                        <i class="bx bx-id-card"></i>
                                        <h4>Acceso a cursos</h4>
                                        <p>Disfruta de acceso ilimitado a una vasta selección de cursos, disponibles en
                                            cualquier momento y desde cualquier dispositivo.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="image col-xl-5 d-flex align-items-stretch justify-content-center order-1 order-lg-2"
                            data-aos="fade-left" data-aos-delay="100">
                            <img src="assets2/img/features.svg" class="img-fluid" alt="">
                        </div>
                    </div>

                </div>
            </section><!-- End App Features Section -->

        <!-- ======= Details Section ======= -->
        <section id="details" class="details">
            <div class="container">

                <div class="row content">
                    <div class="col-md-4" data-aos="fade-right">
                        <img src="assets2/img/details-1.png" class="img-fluid" alt="">
                    </div>
                    <div class="col-md-8 pt-4" data-aos="fade-up">
                        <h3>Obten resultados benficiosos con los cursos y talleres que se ofrecen.</h3>
                        <p class="fst-italic">
                            Nuestros cursos y congresos te brindan las herramientas y el conocimiento práctico que necesitas para alcanzar tus metas profesionales. Aprende de expertos en la industria y desarrolla habilidades.
                        </p>
                        <ul>
                            <li><i class="bi bi-check"></i> Certificación Internacional.</li>
                            <li><i class="bi bi-check"></i> Pago accesible a través de aplicaciones.</li>
                            <li><i class="bi bi-check"></i> Aprendizaje adecuado a tus necesidades.</li>
                            <li><i class="bi bi-check"></i> Tematicas de impacto.</li>
                        </ul>
                        <p>
                            "Amplía tus conocimientos y habilidades con nuestra oferta integral de cursos y congresos. Los cursos te brindan una formación profunda y práctica en áreas específicas, mientras que los congresos te exponen a las últimas tendencias y
                            te conectan con profesionales de tu sector. ¡Combina ambas experiencias y maximiza tu potencial de crecimiento!"
                        </p>
                    </div>
                </div>

                <div class="row content">
                    <div class="col-md-4 order-1 order-md-2" data-aos="fade-left">
                        <img src="assets2/img/details-2.png" class="img-fluid" alt="">
                    </div>
                    <div class="col-md-8 pt-5 order-2 order-md-1" data-aos="fade-up">
                        <h3>Beneficios adicionales</h3>
                        <p class="fst-italic">
                            Participa en actividades colaborativas y discusiones en foros que fomentan la interactividad
                            y el aprendizaje activo. Con acceso ilimitado a nuestros cursos, puedes estudiar cuando y
                            donde quieras, adaptando tu educación a tu estilo de vida.
                        </p>
                        <p>
                            Nuestro compromiso es ofrecerte una educación de calidad, con un soporte constante y
                            recursos actualizados que te ayudarán a alcanzar tus metas académicas y profesionales. Únete
                            a nuestra comunidad de estudiantes y descubre una nueva forma de aprender.
                        </p>

                    </div>
                </div>

                {{-- <div class="row content">
                    <div class="col-md-4" data-aos="fade-right">
                        <img src="assets2/img/details-3.png" class="img-fluid" alt="">
                    </div>
                    <div class="col-md-8 pt-5" data-aos="fade-up">
                        <h3>Sunt consequatur ad ut est nulla consectetur reiciendis animi voluptas</h3>
                        <p>Cupiditate placeat cupiditate placeat est ipsam culpa. Delectus quia minima quod. Sunt saepe
                            odit aut quia voluptatem hic voluptas dolor doloremque.</p>
                        <ul>
                            <li><i class="bi bi-check"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat.
                            </li>
                            <li><i class="bi bi-check"></i> Duis aute irure dolor in reprehenderit in voluptate velit.
                            </li>
                            <li><i class="bi bi-check"></i> Facilis ut et voluptatem aperiam. Autem soluta ad fugiat.
                            </li>
                        </ul>
                        <p>
                            Qui consequatur temporibus. Enim et corporis sit sunt harum praesentium suscipit ut
                            voluptatem. Et nihil magni debitis consequatur est.
                        </p>
                        <p>
                            Suscipit enim et. Ut optio esse quidem quam reiciendis esse odit excepturi. Vel dolores
                            rerum soluta explicabo vel fugiat eum non.
                        </p>
                    </div>
                </div>

                <div class="row content">
                    <div class="col-md-4 order-1 order-md-2" data-aos="fade-left">
                        <img src="assets2/img/details-4.png" class="img-fluid" alt="">
                    </div>
                    <div class="col-md-8 pt-5 order-2 order-md-1" data-aos="fade-up">
                        <h3>Quas et necessitatibus eaque impedit ipsum animi consequatur incidunt in</h3>
                        <p class="fst-italic">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore
                            magna aliqua.
                        </p>
                        <p>
                            Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                            reprehenderit in voluptate
                            velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                            proident, sunt in
                            culpa qui officia deserunt mollit anim id est laborum
                        </p>
                        <ul>
                            <li><i class="bi bi-check"></i> Et praesentium laboriosam architecto nam .</li>
                            <li><i class="bi bi-check"></i> Eius et voluptate. Enim earum tempore aliquid. Nobis et
                                sunt consequatur. Aut repellat in numquam velit quo dignissimos et.</li>
                            <li><i class="bi bi-check"></i> Facilis ut et voluptatem aperiam. Autem soluta ad fugiat.
                            </li>
                        </ul>
                    </div>
                </div> --}}

            </div>
        </section>
        <!-- End Details Section -->

        <!-- ======= Gallery Section ======= -->


        <!-- ======= Testimonials Section ======= -->

        <!-- End Testimonials Section -->



        <!-- ======= Frequently Asked Questions Section ======= -->
        {{-- <section id="faq" class="faq section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">

          <h2>Preguntas más frecuentes</h2>
          <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
        </div>

        <div class="accordion-list">
          <ul>
            <li data-aos="fade-up">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse" data-bs-target="#accordion-list-1">Non consectetur a erat nam at lectus urna duis? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-1" class="collapse show" data-bs-parent=".accordion-list">
                <p>
                  Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="100">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#accordion-list-2" class="collapsed">Feugiat scelerisque varius morbi enim nunc? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-2" class="collapse" data-bs-parent=".accordion-list">
                <p>
                  Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="200">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#accordion-list-3" class="collapsed">Dolor sit amet consectetur adipiscing elit? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-3" class="collapse" data-bs-parent=".accordion-list">
                <p>
                  Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis sed odio morbi quis
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="300">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#accordion-list-4" class="collapsed">Tempus quam pellentesque nec nam aliquam sem et tortor consequat? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-4" class="collapse" data-bs-parent=".accordion-list">
                <p>
                  Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in est ante in. Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing bibendum est. Purus gravida quis blandit turpis cursus in.
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="400">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#accordion-list-5" class="collapsed">Tortor vitae purus faucibus ornare. Varius vel pharetra vel turpis nunc eget lorem dolor? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-5" class="collapse" data-bs-parent=".accordion-list">
                <p>
                  Laoreet sit amet cursus sit amet dictum sit amet justo. Mauris vitae ultricies leo integer malesuada nunc vel. Tincidunt eget nullam non nisi est sit amet. Turpis nunc eget lorem dolor sed. Ut venenatis tellus in metus vulputate eu scelerisque.
                </p>
              </div>
            </li>

          </ul>
        </div>

      </div>
        </section> --}}
        <!-- End Frequently Asked Questions Section -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2><i class="fas fa-comment-alt-exclamation"></i>CONTACTANOS</h2>
                    {{-- <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit
                        sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias
                        ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p> --}}
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6 info">
                                <i class="bx bx-map"></i>
                                <h4>Direcciones</h4>
                                <p>
                                    OFICINA CENTRAL: Av. Melchor Pérez de Olguín e Idelfonso Murgía Nro. 1253 Cochabamba
                                    - Bolivia
                                </p>
                                <p>
                                    OFICINA REGIONAL: Calle Pinilla Edifico Arcadia Nro. 2588 La Paz - Bolivia
                                </p>
                            </div>
                            <div class="col-lg-6 info">
                                <i class="bx bx-phone"></i>
                                <h4>Llamanos</h4>
                                <p>(+591) 72087186 <br>(+591) 4 4284295 <br>(+591) 2 2433208</p>
                            </div>
                            <div class="col-lg-6 info">
                                <i class="bx bx-envelope"></i>
                                <h4>Correo</h4>
                                <p>contacto@educarparalavida.org.bo</p>
                            </div>
                            <div class="col-lg-6 info">
                                <i class="bx bx-time-five"></i>
                                <h4>Horas de Oficina</h4>
                                <p>Lun - Vier: 9AM a 5PM</p>
                            </div>
                        </div>
                    </div>



                </div>

            </div>
        </section><!-- End Contact Section -->

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
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

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center md-5"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets2/vendor/aos/aos.js"></script>
    <script src="assets2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets2/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets2/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets2/vendor/php-email-form/validate.js"></script>

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

@include('botman.tinker')


</body>

</html>
