
@section('titulo')
    Iniciar Sesión
@endsection

@section('content')
<div class="login-card">
    <h3 class="text-center mb-4">Iniciar sesión</h3>
    @guest
    <!-- Formulario de login (solo si NO ha iniciado sesión) -->
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" name="email" id="email" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" required>
                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility(this)">
                    <i class="fa fa-eye"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 btn-login">Ingresar</button>
    </form>
@else
    <!-- Si el usuario ya está autenticado -->
    <div class="alert alert-info text-center">
        Ya has iniciado sesión como <strong>{{ Auth::user()->name }}</strong>.
        <a href="{{ route('home') }}" class="btn btn-sm btn-primary mt-2">Ir al inicio</a>
    </div>
@endguest

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
