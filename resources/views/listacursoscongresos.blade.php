<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Lista de Cursos</title>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <link href="assets2/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets2/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets2/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets2/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets2/css/style.css" rel="stylesheet">


</head>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Detectar cuando cualquier modal se oculta
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('hidden.bs.modal', function() {
                // Buscar y eliminar backdrop sobrante
                document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop
                    .remove());

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
                <a href="{{ route('home') }}"><img src="assets/img/Acceder.png" alt=""
                        style=" height: 35px;"></a>
            </div>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="getstarted scrollto" href="{{ route('home') }}">Inicio</a></li>


                    @if (auth()->user())
                        <li><a class="getstarted scrollto" href="{{ route('Inicio') }}">Ir a Inicio</a></li>
                    @else
                        <li><a class="getstarted scrollto" href="{{ route('login.signin') }}">Iniciar Sesión</a></li>
                        <li><a class="getstarted scrollto" href="{{ route('signin') }}">Registrarse</a></li>
                    @endif
                </ul>
                <div class="ml-5 right d-none d-md-block" style="text-align: right;">
                    <img src="assets/img/logof.png" alt="" class="img-fluid" style="height: 55px;">
                </div>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->

    <!-- Add this CSS to your stylesheet -->
    <style>
        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .badge {
            font-weight: 500;
        }
    </style>
    <!-- ======= Hero Section ======= -->
    <main id="main">
        <!-- ======= Hero Section ======= -->
        <section id="hero" class="d-flex align-items-center"
            style="min-height: 600px; background: linear-gradient(rgba(27, 47, 85, 0.8), rgba(40, 58, 90, 0.7)), url('/api/placeholder/1920/1080') center/cover;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h1 class="text-white mb-4 fw-bold animate__animated animate__fadeInDown">
                            Encuentra tu próximo curso o congreso
                        </h1>
                        <p class="text-white mb-5 lead animate__animated animate__fadeInUp">
                            Explora nuestra amplia biblioteca de cursos y eventos educativos diseñados para impulsar tu
                            carrera
                        </p>

                        <div class="search-form animate__animated animate__fadeInUp">
                            <div class="input-group input-group-lg shadow-lg rounded-pill overflow-hidden">
                                <input type="text" class="form-control border-0 px-4" id="searchInput"
                                    placeholder="¿Qué quieres aprender hoy?" style="height: 65px;">
                                <div class="input-group-append">
                                    <button class="btn btn-primary px-4" type="button" style="height: 65px;"
                                        id="searchButton">
                                        <i class="bi bi-search me-2"></i>
                                        Buscar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-white animate__animated animate__fadeInUp">
                            <p class="mb-2">Búsquedas populares:</p>
                            <div class="popular-searches">
                                <a href="#"
                                    class="badge bg-light text-dark me-2 mb-2 py-2 px-3 rounded-pill">Desarrollo Web</a>
                                <a href="#"
                                    class="badge bg-light text-dark me-2 mb-2 py-2 px-3 rounded-pill">Inteligencia
                                    Artificial</a>
                                <a href="#"
                                    class="badge bg-light text-dark me-2 mb-2 py-2 px-3 rounded-pill">Marketing
                                    Digital</a>
                                <a href="#"
                                    class="badge bg-light text-dark me-2 mb-2 py-2 px-3 rounded-pill">Gestión de
                                    Proyectos</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <style>
            #hero {
                position: relative;
                overflow: hidden;
            }

            .search-form .form-control:focus {
                box-shadow: none;
                border-color: #4154f1;
            }

            .popular-searches .badge {
                transition: all 0.3s ease;
                text-decoration: none;
            }

            .popular-searches .badge:hover {
                background-color: #4154f1 !important;
                color: white !important;
            }

            /* Animaciones */
            .animate__animated {
                animation-duration: 1s;
            }

            @keyframes fadeInDown {
                from {
                    opacity: 0;
                    transform: translate3d(0, -30px, 0);
                }

                to {
                    opacity: 1;
                    transform: translate3d(0, 0, 0);
                }
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translate3d(0, 30px, 0);
                }

                to {
                    opacity: 1;
                    transform: translate3d(0, 0, 0);
                }
            }
        </style>

        <!-- Stats Bar -->
<!-- Complete the layout structure by adding the missing container elements -->
<div class="container py-5">
    <!-- Your existing stats row is here -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="bg-light rounded-3 p-4 shadow-sm">
                <div class="row text-center">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-journal-text fs-1 text-primary me-3"></i>
                            <div class="text-start">
                                <h3 class="mb-0 fw-bold">{{ $cursos->total() }}</h3>
                                <p class="mb-0 text-muted">Cursos disponibles</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-people fs-1 text-primary me-3"></i>
                            <div class="text-start">
                                <h3 class="mb-0 fw-bold">10,000+</h3>
                                <p class="mb-0 text-muted">Estudiantes activos</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-video3 fs-1 text-primary me-3"></i>
                            <div class="text-start">
                                <h3 class="mb-0 fw-bold">500+</h3>
                                <p class="mb-0 text-muted">Instructores expertos</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-star-fill fs-1 text-primary me-3"></i>
                            <div class="text-start">
                                <h3 class="mb-0 fw-bold">4.8/5</h3>
                                <p class="mb-0 text-muted">Calificación promedio</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fix the main content row structure -->
    <div class="row">
        <!-- Sidebar column -->
        <div class="col-lg-3">
            <!-- View Controls -->
            <section>
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center flex-wrap">
                            <div class="btn-group me-3 mb-2 mb-md-0">
                                <button type="button" class="btn btn-outline-primary active" data-view="grid">
                                    <i class="bi bi-grid-3x3-gap-fill"></i>
                                </button>
                                <button type="button" class="btn btn-outline-primary" data-view="list">
                                    <i class="bi bi-list-ul"></i>
                                </button>
                            </div>
                            <span class="text-muted">Mostrando {{ $cursos->count() }} de {{ $cursos->total() }} resultados</span>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3 mt-md-0">
                        <select class="form-select" id="sortOptions">
                            <option value="relevance">Más relevantes</option>
                            <option value="price_asc">Precio: Menor a Mayor</option>
                            <option value="price_desc">Precio: Mayor a Menor</option>
                            <option value="date_desc">Más recientes</option>
                            <option value="rating_desc">Mejor valorados</option>
                        </select>
                    </div>
                </div>

                <!-- Sidebar Filters -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0 py-2">Filtros</h5>
                    </div>
                    <div class="card-body">
                        <!-- Type Filter -->
                        <div class="mb-4">
                            <h6 class="mb-3 fw-bold">Tipo</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-check" type="checkbox" id="coursesCheck" data-filter="type" data-value="curso">
                                <label class="form-check-label" for="coursesCheck">
                                    Cursos
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input filter-check" type="checkbox" id="congressCheck" data-filter="type" data-value="congreso">
                                <label class="form-check-label" for="congressCheck">
                                    Congresos
                                </label>
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div class="mb-4">
                            <h6 class="mb-3 fw-bold">Categoría</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-check" type="checkbox" id="techCheck" data-filter="category" data-value="tecnologia">
                                <label class="form-check-label" for="techCheck">
                                    Tecnología
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-check" type="checkbox" id="businessCheck" data-filter="category" data-value="negocios">
                                <label class="form-check-label" for="businessCheck">
                                    Negocios
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-check" type="checkbox" id="healthCheck" data-filter="category" data-value="salud">
                                <label class="form-check-label" for="healthCheck">
                                    Salud
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input filter-check" type="checkbox" id="designCheck" data-filter="category" data-value="diseno">
                                <label class="form-check-label" for="designCheck">
                                    Diseño
                                </label>
                            </div>
                        </div>

                        <!-- Level Filter -->
                        <div class="mb-4">
                            <h6 class="mb-3 fw-bold">Nivel</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-check" type="checkbox" id="beginnerCheck" data-filter="level" data-value="principiante">
                                <label class="form-check-label" for="beginnerCheck">
                                    Principiante
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input filter-check" type="checkbox" id="intermediateCheck" data-filter="level" data-value="intermedio">
                                <label class="form-check-label" for="intermediateCheck">
                                    Intermedio
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input filter-check" type="checkbox" id="advancedCheck" data-filter="level" data-value="avanzado">
                                <label class="form-check-label" for="advancedCheck">
                                    Avanzado
                                </label>
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-4">
                            <h6 class="mb-3 fw-bold">Precio</h6>
                            <div class="range">
                                <div class="price-display d-flex justify-content-between mb-2">
                                    <span id="priceMin">$0</span>
                                    <span id="priceMax">$1000</span>
                                </div>
                                <input type="range" class="form-range" min="0" max="1000" step="10" id="priceRange">
                            </div>
                        </div>

                        <!-- Clear Filters Button -->
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-secondary" id="clearFilters">
                                <i class="bi bi-x-circle me-2"></i>Limpiar filtros
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Newsletter Card -->
                <div class="card shadow-sm bg-light border-0">
                    <div class="card-body">
                        <h5 class="card-title">¿Quieres recibir nuevos cursos?</h5>
                        <p class="card-text text-muted">Suscríbete a nuestro boletín para recibir actualizaciones sobre nuevos cursos y ofertas especiales.</p>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Tu correo electrónico">
                            <button class="btn btn-primary" type="button">Suscribirse</button>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Main content column -->
        <div class="col-lg-9">
            <!-- Grid View -->
            <div class="row g-4" id="gridView">
                @foreach($cursos as $curso)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="position-relative">
                            @if($curso->imagen)
                                <img src="{{ asset('storage/'.$curso->imagen) }}" class="card-img-top" alt="{{ $curso->nombreCurso }}">
                            @else
                                <img src="{{ asset('assets/img/bg2.png') }}" class="card-img-top" alt="{{ $curso->nombreCurso }}">
                            @endif
                            <span class="badge bg-primary position-absolute top-0 end-0 m-3">
                                {{ ucfirst($curso->tipo) }}
                            </span>
                            <button class="btn btn-sm btn-light position-absolute top-0 start-0 m-3">
                                <i class="bi bi-heart"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                {{-- <span class="badge bg-light text-dark">{{ $curso->categoria }}</span> --}}
                                <span class="badge bg-success">{{ $curso->nivel }}</span>
                            </div>
                            <h5 class="card-title">{{ $curso->nombreCurso }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($curso->descripcion, 100) }}</p>
                            <div class="mb-3">
                                @if($curso->tipo == 'Curso')
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>{{ $curso->duracion }} horas
                                    <i class="bi bi-people ms-3 me-1"></i>{{ $curso->estudiantes ?? 0 }} estudiantes
                                </small>
                                @else
                                <small class="text-muted">
                                    <i class="bi bi-calendar me-1"></i>{{ \Carbon\Carbon::parse($curso->fecha)->format('d M Y') }}
                                    <i class="bi bi-people ms-3 me-1"></i>{{ $curso->cupos ?? 0 }} cupos
                                </small>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                @if($curso->instructor_imagen)
                                    <img src="{{ asset('storage/'.$curso->instructor_imagen) }}" class="rounded-circle me-2" width="30" height="30" alt="{{ $curso->instructor }}">
                                @else
                                    <img src="{{ asset('assets/img/user.png') }}" class="rounded-circle me-2" width="30" height="30" alt="Instructor">
                                @endif
                                <small class="text-muted">{{ $curso->docente->name }} {{ $curso->docente->lastname1 }} </small>
                            </div>
                            <h5 class="text-primary mb-0">${{ number_format($curso->precio, 2) }}</h5>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- List View (Hidden by default) -->
            <div class="row g-4 d-none" id="listView">
                @foreach($cursos as $curso)
                <div class="col-12">
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4 position-relative">
                                @if($curso->imagen)
                                    <img src="{{ asset('storage/'.$curso->imagen) }}" class="img-fluid rounded-start h-100 object-fit-cover" alt="{{ $curso->nombreCurso }}">
                                @else
                                    <img src="{{ asset('assets/img/bg2.png') }}" class="img-fluid rounded-start h-100 object-fit-cover" alt="{{ $curso->nombreCurso }}">
                                @endif
                                <span class="badge bg-primary position-absolute top-0 end-0 m-3">
                                    {{ ucfirst($curso->tipo) }}
                                </span>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body h-100 d-flex flex-column">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="badge bg-success">{{ $curso->nivel }}</span>
                                        <button class="btn btn-sm btn-light">
                                            <i class="bi bi-heart"></i>
                                        </button>
                                    </div>
                                    <h5 class="card-title">{{ $curso->nombreCurso }}</h5>
                                    <p class="card-text text-muted">{{ Str::limit($curso->descripcion, 200) }}</p>
                                    <div class="mb-3">
                                        @if($curso->tipo == 'Curso')
                                        <small class="text-muted">
                                            <i class="bi bi-clock me-1"></i>{{ $curso->duracion }} horas
                                            <i class="bi bi-people ms-3 me-1"></i>{{ $curso->estudiantes ?? 0 }} estudiantes
                                        </small>
                                        @else
                                        <small class="text-muted">
                                            <i class="bi bi-calendar me-1"></i>{{ \Carbon\Carbon::parse($curso->fecha)->format('d M Y') }}
                                            <i class="bi bi-people ms-3 me-1"></i>{{ $curso->cupos ?? 0 }} cupos
                                        </small>
                                        @endif
                                    </div>
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            @if($curso->instructor_imagen)
                                                <img src="{{ asset('storage/'.$curso->instructor_imagen) }}" class="rounded-circle me-2" width="30" height="30" alt="{{ $curso->instructor }}">
                                            @else
                                                <img src="{{ asset('assets/img/user.png') }}" class="rounded-circle me-2" width="30" height="30" alt="Instructor">
                                            @endif
                                            <small class="text-muted">{{ $curso->docente->name }} {{ $curso->docente->lastname1 }}</small>
                                        </div>
                                        <div>
                                            <h5 class="text-primary mb-0">${{ number_format($curso->precio, 2) }}</h5>
                                            <a href="{{ route('congreso.detalle', $curso->id) }}" class="btn btn-sm btn-outline-primary mt-2">Ver detalles</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $cursos->links() }}
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for interactions -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // View switching
    const gridViewBtn = document.querySelector('[data-view="grid"]');
    const listViewBtn = document.querySelector('[data-view="list"]');
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');

    gridViewBtn.addEventListener('click', function() {
        gridView.classList.remove('d-none');
        listView.classList.add('d-none');
        gridViewBtn.classList.add('active');
        listViewBtn.classList.remove('active');
    });

    listViewBtn.addEventListener('click', function() {
        gridView.classList.add('d-none');
        listView.classList.remove('d-none');
        gridViewBtn.classList.remove('active');
        listViewBtn.classList.add('active');
    });

    // Price range slider
    const priceRange = document.getElementById('priceRange');
    const priceMin = document.getElementById('priceMin');
    const priceMax = document.getElementById('priceMax');

    priceRange.addEventListener('input', function() {
        priceMax.textContent = '$' + this.value;
    });

    // Clear filters
    const clearFiltersBtn = document.getElementById('clearFilters');

    clearFiltersBtn.addEventListener('click', function() {
        document.querySelectorAll('.filter-check').forEach(checkbox => {
            checkbox.checked = false;
        });
        priceRange.value = 1000;
        priceMax.textContent = '$1000';
    });

    // Sort options
    const sortOptions = document.getElementById('sortOptions');

    sortOptions.addEventListener('change', function() {
        // Here you would typically trigger a form submission or AJAX request
        // For example:
        // window.location.href = '{{ route("Inicio") }}?sort=' + this.value;
    });

    // Add to favorites
    const favoriteButtons = document.querySelectorAll('.btn-heart');

    favoriteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const icon = this.querySelector('i');
            if (icon.classList.contains('bi-heart')) {
                icon.classList.remove('bi-heart');
                icon.classList.add('bi-heart-fill');
                icon.classList.add('text-danger');
            } else {
                icon.classList.add('bi-heart');
                icon.classList.remove('bi-heart-fill');
                icon.classList.remove('text-danger');
            }
        });
    });
});
</script>
</section>











    </main>


c


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
                        " <a href='' target='_blank'>Fundación Educar para la Vida</a>.");
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

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets2/vendor/aos/aos.js"></script>
    <script src="assets2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets2/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets2/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets2/vendor/php-email-form/validate.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <!-- Template Main JS File -->
    <script src="assets2/js/main.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Escuchar el evento cuando un modal se oculta
            document.querySelectorAll('.modal').forEach(modal => {
                modal.addEventListener('hidden.bs.modal', function() {
                    // Eliminar backdrop manualmente si aún existe
                    document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop
                        .remove());
                    document.body.classList.remove('modal-open'); // Eliminar clase modal-open
                    document.body.style.paddingRight = ''; // Corregir posibles desplazamientos
                });
            });
        });
    </script>

    <script>
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal-backdrop')) {
                document.querySelectorAll('.modal.show').forEach(modal => {
                    let modalInstance = bootstrap.Modal.getInstance(modal);
                    if (modalInstance) modalInstance.hide();
                });
            }
        });
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
