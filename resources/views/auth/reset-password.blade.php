@section('titulo')
Resetear Contraseña
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
            <div class="card shadow-sm"> <!-- Añadí sombra para mejor estética -->


                <div class="card-body "> <!-- Añadí padding para mejor espaciado -->
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
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="new-password" minlength="8">
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
                            <input id="password-confirm" type="password" class="form-control"
                                   name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <!-- Botón de envío -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-lg w-100"> <!-- Botón más grande y ancho completo -->
                                {{ __('Restablecer Contraseña') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include('layoutlogin')
