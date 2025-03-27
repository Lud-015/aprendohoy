
@section('titulo')
    Iniciar Sesión
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card bg-gray-transparent shadow border-0">
                <div class="card-body px-lg-4 py-lg-4">
                    @if (auth()->check())
                        <!-- Si el usuario ya ha iniciado sesión -->
                        <div class="text-center text-muted mb-4">
                            <h5 class="text-white">Ya has iniciado sesión</h5>
                            <a class="btn btn-primary" href="{{ route('Inicio') }}">
                                Volver al inicio
                            </a>
                        </div>
                    @else
                        <!-- Formulario de inicio de sesión -->
                        <div class="text-center text-muted mb-4">
                            <h5 class="text-white">Iniciar Sesión</h5>
                        </div>

                        <!-- Formulario -->
                        <form role="form" method="POST" action="{{ route('login.signin') }}">
                            @csrf
                            <!-- Campo de correo electrónico -->
                            <div class="form-group mb-3">
                                <label for="email" class="sr-only">Correo Electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-text rounded-start-pill"><i class="ni ni-email-83"></i></span>
                                    <input id="email" class="form-control rounded-end-pill" placeholder="Correo Electrónico"
                                           type="email" name="email" value="{{ old('email') }}" required autofocus>
                                </div>
                            </div>

                            <!-- Campo de contraseña -->
                            <div class="form-group mb-3">
                                <label for="password" class="sr-only">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text rounded-start-pill">
                                        <i class="ni ni-lock-circle-open"></i>
                                    </span>
                                    <input id="password" class="form-control" placeholder="Contraseña"
                                           type="password" name="password" required>
                                    <button class="btn btn-secondary  rounded-end-pill" type="button" id="togglePassword">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Botón de envío -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-4 rounded-pill">Acceder</button>
                            </div>
                        </form>

                        <!-- Enlaces adicionales -->
                        <div class="text-center">
                            <a class="text-white d-block mb-2" href="{{ route('signin') }}">Crear una nueva cuenta</a>
                            <a class="text-white" href="{{ route('password.request') }}">¿Olvidaste tu Contraseña?</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para cambiar la visibilidad de la contraseña -->
<script>
    // Obtener elementos
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');

    // Añadir evento de clic al botón
    togglePassword.addEventListener('click', function () {
        // Cambiar el tipo de campo entre 'password' y 'text'
        const type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;

        // Cambiar el icono de ojo dependiendo del tipo
        const icon = type === 'password' ? 'fa-eye' : 'fa-eye-slash';
        togglePassword.innerHTML = `<i class="fa ${icon}"></i>`;
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
@include('layoutlogin')
