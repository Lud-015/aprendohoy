@section('titulo')
Resetear Contraseña
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card "> <!-- Añadí sombra para mejor estética -->
            <h4>Reestablecer Contraseña</h4>
            <div class="card-body"> <!-- Añadí padding para mejor espaciado -->
                <form method="POST" action="{{ route('password.update') }}" class="needs-validation" novalidate>
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- Campo de correo electrónico -->
                    <div class="form-group mb-3">
                        <label hidden for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus readonly>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Campo de nueva contraseña -->
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">{{ __('Nueva Contraseña') }}</label>
                        <div class="input-group">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" required autocomplete="new-password" minlength="8">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <small class="form-text text-muted">
                            La contraseña debe tener al menos 8 caracteres.
                        </small>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Campo de confirmación de contraseña -->
                    <div class="form-group mb-4">
                        <label for="password-confirm" class="form-label">{{ __('Confirma tu Contraseña') }}</label>
                        <div class="input-group">
                            <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" required autocomplete="new-password">
                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Botón de envío -->
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-sm btn-primary btn-lg w-100"> <!-- Botón más grande y ancho completo -->
                            {{ __('Restablecer Contraseña') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Asegúrate de incluir Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle para el campo de contraseña
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            // Toggle tipo de input
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle icono
            const icon = togglePassword.querySelector('i');
            if (type === 'password') {
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        });

        // Toggle para el campo de confirmación de contraseña
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const passwordConfirm = document.getElementById('password-confirm');

        toggleConfirmPassword.addEventListener('click', function() {
            // Toggle tipo de input
            const type = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirm.setAttribute('type', type);

            // Toggle icono
            const icon = toggleConfirmPassword.querySelector('i');
            if (type === 'password') {
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        });
    });
</script>
@endsection
@include('layoutlogin')
