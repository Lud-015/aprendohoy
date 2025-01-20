@section('titulo')

Editar Contraseña
@endsection


@section('nav')
    @if (auth()->user()->hasRole('Administrador'))
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Miperfil') }}">
                    <i class="ni ni-circle-08 text-green"></i> Mi perfil
                </a>
            </li>
            <li class="nav-item  active ">
                <a class="nav-link  active " href="{{ route('Inicio') }}">
                    <i class="ni ni-tv-2 text-primary"></i> Mis Cursos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{ route('ListaDocentes') }}">
                    <i class="ni ni-single-02 text-blue"></i> Lista de Docentes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{ route('ListaEstudiantes') }}">
                    <i class="ni ni-single-02 text-orange"></i> Lista de Estudiantes
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link " href="./examples/tables.html">
                    <i class="ni ni-bullet-list-67 text-red"></i> Aportes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('AsignarCurso') }}">
                    <i class="ni ni-key-25 text-info"></i> Asignación de Cursos
                </a>
            </li>

        </ul>
    @endif

    @if (auth()->user()->hasRole('Docente'))
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Miperfil') }}">
                    <i class="ni ni-circle-08 text-green"></i> Mi perfil
                </a>
            </li>
            <li class="nav-item  active ">
                <a class="nav-link  active " href="{{ route('Inicio') }}">
                    <i class="ni ni-tv-2 text-primary"></i> Mis Cursos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="./examples/tables.html">
                    <i class="ni ni-bullet-list-67 text-red"></i> Aportes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('AsignarCurso') }}">
                    <i class="ni ni-key-25 text-info"></i> Asignación de Cursos
                </a>
            </li>

        </ul>
    @endif

    @if (auth()->user()->hasRole('Estudiante'))
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Miperfil') }}">
                    <i class="ni ni-circle-08 text-green"></i> Mi perfil
                </a>
            </li>
            <li class="nav-item  active ">
                <a class="nav-link  active " href="{{ route('Inicio') }}">
                    <i class="ni ni-tv-2 text-primary"></i> Mis Cursos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="./examples/tables.html">
                    <i class="ni ni-bullet-list-67 text-red"></i> Mis Aportes
                </a>
            </li>


        </ul>
    @endif
@endsection


@section('content')

<div class="border  p-3 my-1 ml-1 mr-1">
<a href="javascript:history.back()" class="btn btn-sm btn-primary">
    &#9668; Volver
</a>
<br>
<div class="col-15 -ml-3">


<form action="{{ route('ambiarContrasenaPost', auth()->user()->id) }}" method="POST">
    @csrf
    <br>
    <h4>Introduce una contraseña antigua</h4>
    <div class="input-group">
        <input class="w-25" type="password" name="oldpassword" id="oldpassword" placeholder="">
        <div class="input-group-append">
            <span class="input-group-text" id="toggleOldPassword">
                <i class="fas fa-eye"></i>
            </span>
        </div>
    </div>
    <h4>Introduce contraseña nueva</h4>
    <div class="input-group">
        <input class="w-25"  type="password" name="password" id="password" oninput="checkPasswordStrength()">
        <div class="input-group-append">
            <span class="input-group-text" id="togglePassword">
                <i class="fas fa-eye"></i>
            </span>
        </div>
    </div>
    <div id="password-strength"></div>
    <h4>Confirma contraseña nueva</h4>
        <div class="input-group">
            <input class="w-25" type="password" name="password_confirmation" id="password_confirmation">
            <div class="input-group-append">
                <span class="input-group-text" id="toggleConfirmPassword">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
        </div>
    <br>
    <br>
    <input class="btn btn-success" type="submit" value="Guardar Cambios">
</form>

<script>
    var oldpasswordInput = document.getElementById('oldpassword');
    var confirmpasswordInput = document.getElementById('password_confirmation');
    var passwordInput = document.getElementById('password');
    var toggleButton1 = document.getElementById('toggleOldPassword');
    var toggleButton2 = document.getElementById('toggleConfirmPassword');
    var toggleButton = document.getElementById('togglePassword');

    toggleButton.addEventListener('click', function() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleButton.innerHTML = '<i class="fas fa-eye-slash"></i>';
        } else {
            passwordInput.type = 'password';
            toggleButton.innerHTML = '<i class="fas fa-eye"></i>';
        }
        }
        );
    toggleButton1.addEventListener('click', function() {
        if (oldpasswordInput.type === 'password') {
            oldpasswordInput.type = 'text';
            toggleButton1.innerHTML = '<i class="fas fa-eye-slash"></i>';
        } else {
            oldpasswordInput.type = 'password';
            toggleButton1.innerHTML = '<i class="fas fa-eye"></i>';
        }
        }
        );
    toggleButton2.addEventListener('click', function() {
        if (confirmpasswordInput.type === 'password') {
            confirmpasswordInput.type = 'text';
            toggleButton2.innerHTML = '<i class="fas fa-eye-slash"></i>';
        } else {
            confirmpasswordInput.type = 'password';
            toggleButton2.innerHTML = '<i class="fas fa-eye"></i>';
        }
    }
    );

</script>




<script>
    function checkPasswordStrength() {
        var password = document.getElementById('password').value;
        var result = zxcvbn(password);
        var strengthMeter = document.getElementById('password-strength');
        var strength = result.score; // This is a score between 0 and 4 indicating the password strength

        var strengthText = '';
        switch (strength) {
            case 0:
                strengthText = 'Muy débil';
                break;
            case 1:
                strengthText = 'Débil';
                break;
            case 2:
                strengthText = 'Media';
                break;
            case 3:
                strengthText = 'Fuerte';
                break;
            case 4:
                strengthText = 'Muy fuerte';
                break;
            default:
                strengthText = '';
        }

        strengthMeter.textContent = 'Fortaleza de la contraseña: ' + strengthText;
    }
</script>

    @if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

    @if ($errors->any())
    @foreach ($errors->all() as $error)
        <h2 class="bg-danger alert-danger">{{$error}}</h2>
    @endforeach
    @endif
</div>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>


@include('layout')
