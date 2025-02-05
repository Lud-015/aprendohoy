
@section('content')
<div class="container pt-lg-6">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card bg-translucent-light shadow border-0">
                <div class="card-body px-lg-4 py-lg-4">
                    @if (auth()->check())
                        <!-- Si el usuario ya ha iniciado sesión -->
                        <div class="text-center text-muted mb-4">
                            <h5 class="text-white">Ya has iniciado sesión</h5>
                            <a class="btn btn-facebook" href="{{ route('Inicio') }}">
                                Volver al inicio
                            </a>
                        </div>
                    @else
                        <!-- Formulario de inicio de sesión -->
                        <div class="text-center text-muted mb-4">
                            <h5 class="text-white">Iniciar Sesión</h5>
                        </div>

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

                        <!-- Formulario -->
                        <form role="form" method="POST" action="{{ route('login.signin') }}">
                            @csrf
                            <!-- Campo de correo electrónico -->
                            <div class="form-group mb-3">
                                <label for="email" class="sr-only">Correo Electrónico</label>
                                <div class="input-group input-group-addon">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="border-radius: 20px 0 0 20px;"><i class="ni ni-email-83"></i></span>
                                    </div>
                                    <input id="email" class="form-control" style="border-radius: 0 20px 20px 0;" placeholder="Correo Electrónico"
                                           type="email" name="email" value="{{ old('email') }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="password" class="sr-only">Contraseña</label>
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="border-radius: 20px 0 0 20px;">
                                            <i class="ni ni-lock-circle-open"></i>
                                        </span>
                                    </div>
                                    <input id="password" class="form-control" style="border-radius: 0 20px 20px 0;" placeholder="Contraseña"
                                           type="password" name="password" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" style="border-radius: 0 20px 20px 0;" type="button"
                                                onclick="togglePasswordVisibility(this)">
                                            <i class="fa fa-eye"></i> <!-- Ícono dentro del botón -->
                                        </button>
                                    </div>
                                </div>
                            </div>




                            <!-- Botón de envío -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-facebook my-4" style="border-radius: 20px;">Acceder</button>
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

<script>
    function togglePasswordVisibility(button) {
        const passwordInput = document.getElementById('password'); // Obtener el campo de contraseña
        const icon = button.querySelector('i'); // Obtener el ícono dentro del botón

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text'; // Mostrar la contraseña
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password'; // Ocultar la contraseña
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection

@include('layoutlogin')
