
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


<<<<<<< HEAD
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
=======
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>INICIAR SESION</title>
</head>
<body>
>>>>>>> cb8fa77f0ef74b746ba20ffad46948ba09d39ee0

        toggleButton.addEventListener('click', function() {
            // Toggle type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

<<<<<<< HEAD
            // Toggle icon
            const icon = toggleButton.querySelector('i');
            if (type === 'password') {
                icon.classList.remove('fa fa-eye-slash');
                icon.classList.add('fa fa-eye');
            } else {
                icon.classList.remove('fa fa-eye');
                icon.classList.add('fa fa-eye-slash');
            }
        });
    });
</script>
=======
@if (auth()->check())


<a href="{{route('logout')}}">Cerrar Sesion</a>


<h1>YA INICIASTE SESION </h1>


@else

<h1>INICIAR SESIÓN</h1>

   <form method="POST">
      @csrf
      <label for="">Correo Electronico</label>
      <br>
      <input type="text" name="email">
      <br>
      <label for="">Contraseña</label>
      <br>
      <input type="password" name="password">
      <br>
      <br>
      <a href="">Olvidaste la contraseña</a>
      <br>
      <br>
      <a href="">No tienes cuenta? Crea Una</a>
      <br>
      <br>
      <button class="btn btn-danger btn-block btn-round">Inciar Sesion</button>

   </form>



@endif
   </body>
</html>

>>>>>>> cb8fa77f0ef74b746ba20ffad46948ba09d39ee0

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
@include('layoutlogin')
