@section('hero')



    <section id="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-lg-flex flex-lg-column justify-content-center align-items-stretch pt-5 pt-lg-0 order-2 order-lg-1"
                    data-aos="fade-up">
                    <div>
                        <h3>

                            @if ($cursos->tipo == 'curso')
                                Curso: {{ $cursos->nombreCurso }}
                            @elseif ($cursos->tipo == 'congreso')
                                Congreso: {{ $cursos->nombreCurso }}
                            @endif
                        </h3>
                        <h2>{{ $cursos->descripcionC }}</h2>


                        @php
                            \Carbon\Carbon::setLocale('es');
                        @endphp

                        <h2>📅 {{ \Carbon\Carbon::parse($cursos->fecha_ini)->translatedFormat('d \d\e F \d\e Y') }} </h2>










                        <div class="card shadow-lg rounded-3 border-0 overflow-hidden">
                            @if ($usuarioInscrito)
                                <div class="card-header bg-light py-3 px-4 border-bottom">
                                    <h4 class="mb-0 fw-bold">
                                        <i class="bi bi-mortarboard-fill me-2 text-success"></i>
                                        @if ($cursos->tipo == 'curso')
                                            Acceso al Curso
                                        @else
                                            Obtener Cerificado
                                        @endif

                                    </h4>
                                </div>
                                <div class="card-body p-4">

                                    @if ($cursos->tipo == 'curso')
                                        <a class="btn btn-sm btn-success" href="{{ route('Curso', $cursos->id) }}">
                                            <i class="bi bi-door-open me-2"></i> Ir al Curso
                                        </a>
                                    @else
                                        @if (is_null($usuarioInscrito->certificado))
                                            <p>Ponte en contacto con el colaborador del evento.</p>
                                        @else
                                            <ul>
                                                <li class="text-success">
                                                    <i class="bi bi-award-fill me-2"></i>
                                                    <a href="{{ route('verificar.certificado', $usuarioInscrito->certificado->codigo_certificado) }}"
                                                        target="_blank">Descargar Certificado</a>
                                                </li>
                                            </ul>
                                        @endif
                                    @endif
                                </div>
                            @else
                                <div class="card-header bg-light py-3 px-4 border-bottom">
                                    <h4 class="mb-0 fw-bold">
                                        @if ($cursos->tipo == 'curso')
                                            <i class="bi bi-mortarboard-fill me-2 text-success"></i>Acceso al Curso
                                        @else
                                            <i class="bi bi-calendar-event me-2 text-primary"></i>Registro al Congreso
                                        @endif
                                    </h4>
                                </div>
                                <div class="card-body p-4">
                                    @if ($cursos->tipo == 'curso')
                                        <div class="text-center mb-4">
                                            <span class="badge bg-success-subtle text-success px-3 py-2 mb-2">Oferta
                                                Especial</span>
                                            <h3 class="fw-bold text-success mb-1">$ {{ number_format($cursos->precio, 2) }}
                                            </h3>
                                            <p class="text-muted">Pago único, acceso de por vida</p>
                                            <div class="d-flex justify-content-center align-items-center gap-2 mb-2">
                                                <i class="bi bi-check-circle-fill text-success"></i>
                                                <span>Certificado Digital Incluido</span>
                                            </div>
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <i class="bi bi-check-circle-fill text-success"></i>
                                                <span>Soporte 24/7</span>
                                            </div>
                                        </div>

                                        <button class="btn btn-success w-100 py-3 fw-bold fs-5" data-bs-toggle="modal"
                                            data-bs-target="#{{ auth()->check() ? 'compraCursoModal' : 'loginRequiredModal' }}">
                                            <i class="bi bi-credit-card me-2"></i> Comprar Ahora
                                        </button>

                                        <!-- Modal para usuarios autenticados -->
                                        @auth
                                            <div class="modal fade" id="compraCursoModal" tabindex="-1"
                                                aria-labelledby="compraCursoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="compraCursoModalLabel">
                                                                {{ $cursos->precio > 0 ? 'Completar Compra' : 'Confirmar Inscripción' }}
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('pagarCurso') }}" method="POST"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <!-- Nombre / Razón Social -->
                                                                <div class="mb-3">
                                                                    <label class="form-label">Usuario:</label>
                                                                    <input type="text" name="user"
                                                                        value="{{ auth()->user()->name }} {{ auth()->user()->lastname1 }} {{ auth()->user()->lastname2 }}"
                                                                        class="form-control" readonly>
                                                                </div>

                                                                <hr>

                                                                <!-- Campo oculto con ID del estudiante -->
                                                                <input type="hidden" name="estudiante_id"
                                                                    value="{{ auth()->user()->id }}">

                                                                <!-- Curso (selección única) -->
                                                                <div class="mb-3">
                                                                    <label class="form-label">Curso:</label>
                                                                    <select name="curso_id" class="form-select">
                                                                        <option value="{{ $cursos->id }}" selected>
                                                                            {{ $cursos->nombreCurso }}
                                                                            ({{ $cursos->precio > 0 ? '$' . number_format($cursos->precio, 2) : 'Gratuito' }})
                                                                        </option>
                                                                    </select>
                                                                </div>

                                                                @if ($cursos->precio > 0)
                                                                    <div class="row">
                                                                        <!-- Monto a Pagar -->
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label">Monto a Pagar:</label>
                                                                            <div class="input-group">
                                                                                <input type="number" name="montopagar"
                                                                                    class="form-control"
                                                                                    value="{{ $cursos->precio }}"
                                                                                    min="1" step="any" required
                                                                                    readonly>
                                                                                <span class="input-group-text">$</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label">Comprobante:</label>
                                                                        <input type="file" name="comprobante"
                                                                            class="form-control" accept=".pdf,.jpg,.png"
                                                                            required>
                                                                        <small class="text-muted">Formatos aceptados: PDF, JPG,
                                                                            PNG (Max. 2MB)</small>
                                                                    </div>
                                                                @endif

                                                                <!-- Descripción -->
                                                                <div class="mb-3">
                                                                    <label class="form-label">Descripción:</label>
                                                                    <textarea name="descripcion" class="form-control" rows="3" required>
                                                                    @if ($cursos->precio > 0)
Pago del curso {{ $cursos->nombreCurso }}@elseInscripción al curso gratuito {{ $cursos->nombreCurso }}
@endif
                                                                    </textarea>
                                                                </div>

                                                                @if ($cursos->precio > 0)
                                                                    <div class="m-3 text-center">
                                                                        <img src="{{ asset('assets/img/pago.png') }}"
                                                                            alt="Métodos de pago" class="img-fluid">
                                                                        <small class="text-muted d-block">Por favor adjunte su
                                                                            comprobante de pago</small>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancelar</button>
                                                                <button type="submit" class="btn btn-success">
                                                                    {{ $cursos->precio > 0 ? 'Confirmar Compra' : 'Confirmar Inscripción' }}
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endauth

                                        @guest
                                            <div class="modal fade" id="loginRequiredModal" tabindex="-1"
                                                aria-labelledby="loginRequiredModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="loginRequiredModalLabel">Acceso
                                                                Requerido</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <i class="bi bi-exclamation-circle text-warning"
                                                                style="font-size: 3rem;"></i>
                                                            <h4 class="my-3">Debes iniciar sesión para continuar</h4>
                                                            <p>Para realizar una compra necesitas tener una cuenta en nuestro
                                                                sistema.</p>
                                                        </div>
                                                        <div class="modal-footer justify-content-center">
                                                            <a href="{{ route('login') }}" class="btn btn-primary me-2">
                                                                <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                                                            </a>
                                                            <a href="{{ route('signin') }}" class="btn btn-success">
                                                                <i class="bi bi-person-plus"></i> Registrarse
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endguest
                                    @else
                                        <!-- Información del Congreso -->
                                        <div class="text-center mb-4">

                                            @if (isset($cursos->precio) && $cursos->precio > 0)
                                                <h3 class="fw-bold text-primary mb-1">$
                                                    {{ number_format($cursos->precio, 2) }}
                                                </h3>
                                            @else
                                                <h3 class="fw-bold text-primary mb-1">Acceso Gratuito</h3>
                                            @endif

                                            <div class="d-flex justify-content-center align-items-center gap-2 mb-2">
                                                <i class="bi bi-check-circle-fill text-primary"></i>
                                                <span>Material del Congreso</span>
                                            </div>
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <i class="bi bi-check-circle-fill text-primary"></i>
                                                <span>Certificado de Asistencia</span>
                                            </div>
                                        </div>

                                        @if ($cursos->certificados_disponibles = true)
                                            @if (auth()->user())
                                                <div class="text-center mb-3">
                                                    <h3>Tiempo Disponible</h3>
                                                    <div id="countdown-timer"
                                                        class="badge bg-primary-subtle text-primary px-3 py-2"></div>
                                                </div>


                                                <form action="{{ route('certificados.obtener', $cursos->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="congreso_id"
                                                        value="{{ $cursos->id }}">

                                                    <div class="d-grid gap-2">
                                                        <button type="submit" class="btn btn-success btn-lg py-3">
                                                            <i class="bi bi-award-fill me-2"></i>
                                                            Obtener Mi Certificado Ahora
                                                        </button>
                                                    </div>
                                                </form>
                                            @else
                                                <div class="text-center mb-3">
                                                    <h3>Tiempo Disponinble</h4>
                                                        <div id="countdown-timer"
                                                            class="badge bg-primary-subtle text-primary px-3 py-2"></div>
                                                </div>
                                                <button
                                                    class="btn btn-primary w-100 py-3 fw-bold fs-5 d-flex align-items-center justify-content-center gap-2"
                                                    data-bs-toggle="modal" data-bs-target="#opcionesRegistroModal">
                                                    <i class="bi bi-person-plus-fill"></i>
                                                    <span>Registrarse Ahora</span>
                                                </button>
                                            @endif
                                        @else
                                            <div class="d-grid gap-2">
                                                <button class="btn btn-info btn-lg py-3">
                                                    <i class="bi bi-award-fill me-2"></i>
                                                    El certificado no esta disponible
                                                </button>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            @endif
                        </div>





                        @if ($cursos->certificados_disponibles)

                            @if (auth()->user())
                            @else
                                <div class="modal fade" id="opcionesRegistroModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title">Opciones de Registro</h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center p-4">
                                                <p class="mb-4">¿Cómo deseas continuar?</p>

                                                <button class="btn btn-primary w-100 py-3 mb-3" data-bs-dismiss="modal"
                                                    data-bs-toggle="modal" data-bs-target="#registroCongresoModal">
                                                    <i class="bi bi-person-plus me-2"></i>Nuevo Registro
                                                </button>

                                                <button class="btn btn-outline-primary w-100 py-3" data-bs-dismiss="modal"
                                                    data-bs-toggle="modal" data-bs-target="#loginModal">
                                                    <i class="bi bi-person-check me-2"></i>Ya tengo cuenta
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header bg-primary text-white py-3">
                                                <h5 class="modal-title">
                                                    <i class="bi bi-person-check me-2"></i>Coloca tu correo electronico si
                                                    ya
                                                    estas registrado
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <form action="{{ route('congreso.inscribir') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="congreso_id"
                                                        value="{{ $cursos->id }}">

                                                    <div class="mb-3">
                                                        <label for="loginEmail" class="form-label">Correo
                                                            Electrónico</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light">
                                                                <i class="bi bi-envelope"></i>
                                                            </span>
                                                            <input type="email" class="form-control" id="loginEmail"
                                                                name="email" required placeholder="tu@email.com">
                                                        </div>
                                                        <small class="text-muted">Ingresa el email con el que estás
                                                            registrado</small>
                                                    </div>

                                                    <div class="d-grid gap-2">
                                                        <button type="submit" class="btn btn-primary py-3">
                                                            <i class="bi bi-award me-2"></i> Obtener Certificado
                                                        </button>


                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer justify-content-center bg-light py-3">
                                                <small class="text-muted">
                                                    ¿No tienes cuenta?
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#registroCongresoModal" data-bs-dismiss="modal">
                                                        Regístrate aquí
                                                    </a>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="registroCongresoModal" tabindex="-1"
                                    aria-labelledby="registroCongresoModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header bg-primary text-white py-3">
                                                <h5 class="modal-title" id="registroCongresoModalLabel">
                                                    <i class="bi bi-person-badge me-2"></i>Registro al Congreso
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <!-- Mensajes de error -->
                                                @if ($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul class="mb-0">
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif

                                                <form action="{{ route('registrarseCongreso', $cursos->id) }}"
                                                    method="POST" id="formRegistroCongreso">
                                                    @csrf

                                                    <!-- Campos de nombre y apellidos -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-4 mb-3">
                                                            <label for="name" class="form-label">Nombre</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text bg-light"><i
                                                                        class="bi bi-person"></i></span>
                                                                <input type="text" class="form-control" id="name"
                                                                    name="name" placeholder="Nombre"
                                                                    value="{{ old('name') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label for="lastname1" class="form-label">Apellido
                                                                Paterno</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text bg-light"><i
                                                                        class="bi bi-person"></i></span>
                                                                <input type="text" class="form-control" id="lastname1"
                                                                    name="lastname1" placeholder="Apellido Paterno"
                                                                    value="{{ old('lastname1') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label for="lastname2" class="form-label">Apellido
                                                                Materno</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text bg-light"><i
                                                                        class="bi bi-person"></i></span>
                                                                <input type="text" class="form-control" id="lastname2"
                                                                    name="lastname2" placeholder="Apellido Materno"
                                                                    value="{{ old('lastname2') }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Campo de correo electrónico -->
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Correo
                                                            Electrónico</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light"><i
                                                                    class="bi bi-envelope"></i></span>
                                                            <input type="email" class="form-control" id="email"
                                                                name="email" placeholder="ejemplo@correo.com"
                                                                value="{{ old('email') }}" required>
                                                        </div>
                                                    </div>

                                                    <!-- Campos de contraseña y confirmación -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="password" class="form-label">Contraseña</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text bg-light"><i
                                                                        class="bi bi-lock"></i></span>
                                                                <input type="password" class="form-control"
                                                                    id="password" name="password"
                                                                    placeholder="Contraseña" required>
                                                                <button class="btn btn-outline-secondary toggle-password"
                                                                    type="button" data-target="password">
                                                                    <i class="bi bi-eye"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="password_confirmation"
                                                                class="form-label">Confirmar
                                                                Contraseña</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text bg-light"><i
                                                                        class="bi bi-lock"></i></span>
                                                                <input type="password" class="form-control"
                                                                    id="password_confirmation"
                                                                    name="password_confirmation"
                                                                    placeholder="Confirmar Contraseña" required>
                                                                <button class="btn btn-outline-secondary toggle-password"
                                                                    type="button" data-target="password_confirmation">
                                                                    <i class="bi bi-eye"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <!-- Campo de país -->
                                                    <div class="mb-3">
                                                        <label for="country" class="form-label">País</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light"><i
                                                                    class="bi bi-globe"></i></span>
                                                            <select class="form-control" id="country" name="country"
                                                                required>
                                                                <option value="">Selecciona tu país</option>
                                                                <!-- Opciones de países se llenarán con JavaScript -->
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                                                        <i class="bi bi-check2-circle me-2"></i>Confirmar Registro
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="modal-footer justify-content-center bg-light py-3">
                                                <small class="text-muted">
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    ¿Ya tienes una cuenta? <a href="{{ route('login.signin') }}">Inicia
                                                        sesión
                                                        aquí</a>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                        @endif


                        <script>
                            // Fecha de finalización del curso
                            const endDate = new Date("{{ $cursos->fecha_fin }}".replace(' ', 'T')).getTime();

                            const countdown = setInterval(function() {
                                const now = new Date().getTime();
                                const distance = endDate - now;

                                // Cálculos de tiempo
                                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                // Mostrar el resultado
                                const timerElement = document.getElementById("countdown-timer");

                                if (distance > 0) {
                                    timerElement.innerHTML = `Tiempo restante: ${days}d ${hours}h ${minutes}m ${seconds}s`;
                                } else {
                                    clearInterval(countdown);
                                    timerElement.innerHTML = "¡Tiempo agotado!";
                                    timerElement.className = "badge bg-danger-subtle text-danger px-3 py-2";

                                    // Deshabilitar todos los botones relevantes
                                    const buttonsToDisable = [
                                        'button[data-bs-target="#opcionesRegistroModal"]',
                                        'button[data-bs-target="#registroCongresoModal"]',
                                        'button[data-bs-target="#loginModal"]',
                                        'form button[type="submit"]'
                                    ];

                                    buttonsToDisable.forEach(selector => {
                                        document.querySelectorAll(selector).forEach(button => {
                                            button.disabled = true;
                                            button.classList.remove('btn-primary', 'btn-success');
                                            button.classList.add('btn-secondary');
                                            button.innerHTML = '<i class="bi bi-lock-fill me-2"></i>Tiempo agotado';
                                        });
                                    });

                                    // También deshabilitar el botón de certificado si existe
                                    const certButton = document.querySelector('form[action*="certificados.obtener"] button');
                                    if (certButton) {
                                        certButton.disabled = true;
                                        certButton.classList.remove('btn-success');
                                        certButton.classList.add('btn-secondary');
                                        certButton.innerHTML = '<i class="bi bi-lock-fill me-2"></i>Certificado no disponible';
                                    }
                                }
                            }, 1000);
                        </script>

                        <!-- Script para manejar la visibilidad de contraseñas y cargar países -->
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                // Toggle password visibility
                                document.querySelectorAll('.toggle-password').forEach(button => {
                                    button.addEventListener('click', function() {
                                        const targetId = this.getAttribute('data-target');
                                        const input = document.getElementById(targetId);
                                        const icon = this.querySelector('i');

                                        if (input.type === 'password') {
                                            input.type = 'text';
                                            icon.classList.remove('bi-eye');
                                            icon.classList.add('bi-eye-slash');
                                        } else {
                                            input.type = 'password';
                                            icon.classList.remove('bi-eye-slash');
                                            icon.classList.add('bi-eye');
                                        }
                                    });
                                });

                                // Cargar países (ejemplo con algunos países)
                                const countries = [
                                    // América del Norte
                                    "Canada", "Estados Unidos", "México",

                                    // América Central y el Caribe
                                    "Belice", "Costa Rica", "Cuba", "El Salvador", "Guatemala", "Honduras", "Nicaragua", "Panamá",
                                    "República Dominicana",

                                    // América del Sur
                                    "Argentina", "Bolivia", "Brasil", "Chile", "Colombia", "Ecuador", "Guyana", "Paraguay", "Perú",
                                    "Surinam",
                                    "Uruguay", "Venezuela",

                                    // Europa
                                    "Alemania", "Francia", "España", "Italia", "Reino Unido", "Portugal", "Países Bajos", "Bélgica",
                                    "Suiza",
                                    "Austria", "Grecia", "Suecia", "Noruega",

                                    // Asia
                                    "China", "India", "Japón", "Corea del Sur", "Indonesia", "Filipinas", "Malasia", "Singapur",
                                    "Tailandia",
                                    "Vietnam", "Israel", "Turquía", "Arabia Saudita",

                                    // Oceanía
                                    "Australia", "Nueva Zelanda"
                                ];

                                const countrySelect = document.getElementById('country');
                                countries.forEach(country => {
                                    const option = document.createElement('option');
                                    option.value = country;
                                    option.textContent = country;
                                    countrySelect.appendChild(option);
                                });
                            });
                        </script>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="200">
                    <div id="courseCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner rounded-3 shadow">

                            {{-- Si el curso tiene un video de YouTube --}}
                            @php
                                $index = 0;
                                $youtubeUrl = $cursos->youtube_url;
                                $videoId = null;

                                if ($youtubeUrl) {
                                    preg_match(
                                        '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|embed)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/',
                                        $youtubeUrl,
                                        $matches,
                                    );
                                    $videoId = $matches[1] ?? null;
                                }
                            @endphp

                            @if ($videoId)
                                <div class="carousel-item active">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0"
                                            allowfullscreen></iframe>
                                    </div>
                                </div>
                                @php $index++; @endphp
                            @endif

                            @forelse ($cursos->imagenes->where('activo', true)->values() as $i => $media)
                                <div class="carousel-item {{ !$videoId && $i === 0 ? 'active' : '' }}">
                                    <img src="{{ asset($media->url) }}" class="d-block w-100"
                                        alt="{{ $media->titulo ?? 'Imagen de curso' }}">
                                </div>
                            @empty
                                @if (!$videoId)
                                    <div class="carousel-item active">
                                        <img src="{{ asset('assets2/img/congress.jpg') }}" class="d-block w-100"
                                            alt="Imagen por defecto">
                                    </div>
                                @endif
                            @endforelse
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#courseCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#courseCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                </div>

                <!-- Sección de Valoraciones -->




            </div>

        </div>
    </section><!-- End Hero -->

    @if ($cursos->tipo == 'curso')
        <section class="mt-5" id="temario">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-header bg-light">
                                <h3 class="mb-0">
                                    <i class="bi bi-journal-text text-primary me-2"></i>Temario del Curso
                                </h3>
                            </div>
                            <div class="card-body">
                                @forelse ($cursos->temas->sortBy('orden') as $i => $tema)
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">{{ $tema->titulo_tema }}</h5>
                                            <button class="btn btn-sm btn-outline-primary" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#descripcionTema{{ $i }}"
                                                aria-expanded="false" aria-controls="descripcionTema{{ $i }}">
                                                Ver descripción
                                            </button>
                                        </div>
                                        <div class="collapse mt-2" id="descripcionTema{{ $i }}">
                                            <div class="card card-body">
                                                {{ $tema->descripcion }}
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted">No hay temas registrados para este curso.</p>
                                @endforelse
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-header bg-light">
                                <h3 class="mb-0">
                                    <i class="bi bi-people text-primary me-2"></i>Facilitadores del Evento
                                </h3>
                            </div>
                            <div class="card-body">
                                @if ($cursos->expositores->isNotEmpty())
                                    <div id="expositoresCarousel" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">

                                            @foreach ($cursos->expositores as $index => $expositor)
                                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                    <div class="d-flex flex-column align-items-center text-center">
                                                        {{-- Imagen del expositor (usa una imagen por defecto si no tiene) --}}
                                                        <img src="{{ $expositor->imagen ? asset('storage/' . $expositor->imagen) : asset('assets2/img/talker.png') }}"
                                                            class="rounded-circle mb-3" alt="{{ $expositor->nombre }}"
                                                            style="width: 150px; height: 150px; object-fit: cover;">


                                                        {{-- Información del expositor --}}
                                                        <h5 class="fw-bold">{{ $expositor->nombre }}</h5>
                                                        <p class="text-muted mb-1">
                                                            {{ $expositor->pivot->cargo ?? 'Cargo no especificado' }}</p>
                                                        <p class="mb-0"><strong>Tema:</strong>
                                                            {{ $expositor->pivot->tema ?? 'Tema no definido' }}</p>
                                                        {{-- <p class="mb-0"><strong>Fecha:</strong>
                                                            {{ \Carbon\Carbon::parse($expositor->pivot->fecha_presentacion)->format('d/m/Y') ?? 'No asignada' }}
                                                        </p> --}}
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>

                                        {{-- Controles --}}
                                        <button class="carousel-control-prev" type="button"
                                            data-bs-target="#expositoresCarousel" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Anterior</span>
                                        </button>
                                        <button class="carousel-control-next" type="button"
                                            data-bs-target="#expositoresCarousel" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Siguiente</span>
                                        </button>
                                    </div>
                                @else
                                    <p class="text-muted">No hay expositores asignados.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    @endif


    <section class="mt-5" id="valoraciones">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-header bg-light">
                            <h3 class="mb-0">
                                <i class="bi bi-star-fill text-warning me-2"></i>Valoraciones del Curso
                            </h3>
                        </div>
                        <div class="card-body">
                            <!-- Resumen de Calificaciones -->
                            <div class="row align-items-center mb-4">
                                <div class="col-md-3 text-center">
                                    <div class="display-4 fw-bold text-primary">
                                        {{ number_format($cursos->calificaciones_avg_puntuacion, 1) }}
                                    </div>
                                    <div class="stars mb-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                                class="bi bi-star-fill {{ $i <= round($cursos->calificaciones_avg_puntuacion) ? 'text-warning' : 'text-secondary' }}"></i>
                                        @endfor
                                    </div>
                                    <small class="text-muted">Basado en {{ $cursos->calificaciones_count }}
                                        valoraciones</small>
                                </div>
                                <div class="col-md-9">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <div class="row align-items-center mb-2">
                                            <div class="col-2 text-end">
                                                <small>{{ $i }} <i
                                                        class="bi bi-star-fill text-warning"></i></small>
                                            </div>
                                            <div class="col-7">
                                                <div class="progress" style="height: 8px;">
                                                    @php
                                                        $percentage =
                                                            $cursos->calificaciones_count > 0
                                                                ? ($cursos->calificaciones
                                                                        ->where('puntuacion', $i)
                                                                        ->count() /
                                                                        $cursos->calificaciones_count) *
                                                                    100
                                                                : 0;
                                                    @endphp
                                                    <div class="progress-bar bg-warning" role="progressbar"
                                                        style="width: {{ $percentage }}%"
                                                        aria-valuenow="{{ $percentage }}" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <small
                                                    class="text-muted">{{ $cursos->calificaciones->where('puntuacion', $i)->count() }}</small>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>

                            <style>
                                .rating-stars-input {
                                    direction: rtl;
                                    /* Orden inverso para facilitar la selección */
                                    unicode-bidi: bidi-override;
                                    display: inline-block;
                                    font-size: 0;
                                    /* Elimina espacios entre elementos inline */
                                    margin: 10px 0;
                                }

                                .rating-stars-input input[type="radio"] {
                                    display: none;
                                    /* Oculta los radios reales */
                                }

                                .rating-stars-input label {
                                    color: #ddd;
                                    /* Color de estrellas no seleccionadas */
                                    font-size: 32px;
                                    padding: 0 3px;
                                    cursor: pointer;
                                    transition: all 0.2s ease;
                                    display: inline-block;
                                    position: relative;
                                }

                                /* Estrella seleccionada y las anteriores */
                                .rating-stars-input input[type="radio"]:checked~label,
                                .rating-stars-input label:hover,
                                .rating-stars-input label:hover~label {
                                    color: #FFD700;
                                    /* Color dorado para estrellas seleccionadas */
                                    text-shadow: 0 0 5px rgba(255, 215, 0, 0.5);
                                }

                                /* Efecto hover */
                                .rating-stars-input label:hover {
                                    transform: scale(1.2);
                                }

                                /* Estilo para cuando el campo es requerido y no está seleccionado */
                                .rating-stars-input:has(input[type="radio"]:required:not(:checked)) label {
                                    animation: pulse 2s infinite;
                                }

                                @keyframes pulse {
                                    0% {
                                        color: #ddd;
                                    }

                                    50% {
                                        color: #ffcccc;
                                    }

                                    100% {
                                        color: #ddd;
                                    }
                                }

                                /* Estilo para pantallas pequeñas */
                                @media (max-width: 576px) {
                                    .rating-stars-input label {
                                        font-size: 24px;
                                        padding: 0 2px;
                                    }
                                }
                            </style>

                            <!-- Formulario de Valoración (solo para usuarios inscritos) -->
                            @if ($usuarioInscrito && !$usuarioCalifico)
                                <div class="rating-form mb-5 p-4 bg-light rounded-3">
                                    <h5><i class="bi bi-pencil-square me-2"></i>Deja tu valoración</h5>
                                    <form action="{{ route('cursos.calificar', $cursos->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Tu calificación:</label>
                                            <div class="rating-stars-input">
                                                @for ($i = 5; $i >= 1; $i--)
                                                    <input type="radio" id="star{{ $i }}" name="puntuacion"
                                                        value="{{ $i }}" required>
                                                    <label for="star{{ $i }}">★</label>
                                                @endfor
                                            </div>
                                            @error('puntuacion')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="comentario" class="form-label">Comentario
                                                (opcional):</label>
                                            <textarea name="comentario" class="form-control" rows="3" placeholder="¿Qué te pareció el curso?">{{ old('comentario') }}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-send-fill me-1"></i> Enviar Valoración
                                        </button>
                                    </form>
                                </div>
                            @elseif($usuarioCalifico)
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    Ya calificaste este curso con {{ $calificacionUsuario->puntuacion }}
                                    estrellas.
                                    @if ($calificacionUsuario->comentario)
                                        <div class="mt-2">
                                            <strong>Tu comentario:</strong>
                                            <p class="mb-0">{{ $calificacionUsuario->comentario }}</p>
                                        </div>
                                    @endif
                                </div>
                            @elseif(!Auth::check())
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    <a href="{{ route('login') }}" class="alert-link">Inicia sesión</a> y
                                    únete al curso para poder calificar.
                                </div>
                            @endif

                            <!-- Listado de Valoraciones -->
                            <h5 class="mt-4 mb-3"><i class="bi bi-chat-square-quote-fill me-2"></i>Últimas
                                valoraciones</h5>

                            @forelse($calificacionesRecientes as $calificacion)
                                <div class="card mb-3 border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h6 class="mb-1">{{ $calificacion->user->name }}</h6>
                                                <div class="stars small">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i
                                                            class="bi bi-star-fill {{ $i <= $calificacion->puntuacion ? 'text-warning' : 'text-secondary' }}"></i>
                                                    @endfor
                                                    <small
                                                        class="text-muted ms-2">{{ $calificacion->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                            @if (auth()->id() === $calificacion->user_id)
                                                <form action="{{ route('calificaciones.destroy', $calificacion->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            @hasrole('Administrador')
                                                <form action="{{ route('calificaciones.destroy', $calificacion->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endrole
                                        </div>
                                        @if ($calificacion->comentario)
                                            <p class="mt-2 mb-0">{{ $calificacion->comentario }}</p>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <i class="bi bi-chat-square-text text-muted" style="font-size: 2rem;"></i>
                                    <p class="text-muted mt-2">Aún no hay valoraciones para este curso</p>
                                </div>
                            @endforelse

                            @if ($cursos->calificaciones_count > 5)
                                <div class="text-center mt-3">
                                    <a href="{{ route('cursos.allRatings', $cursos->id) }}"
                                        class="btn btn-outline-primary">
                                        <i class="bi bi-list-ul me-1"></i> Ver todas las valoraciones
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection





@include('layoutlanding')
