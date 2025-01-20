@section('titulo')

Editar Perfil
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
<div class="border p-3">
<a href="javascript:history.back()" class="btn btn-primary">
    &#9668; Volver
</a>
<br>
<br>
    <form action="{{route('EditarperfilUser', $usuario->id)}}" method="POST" >
        @csrf
         <h4>Datos Personales</h4>

         <br>
         <div class="mb-4">
             <label for="name">Nombre</label>
             <br>
             <input type="text" value="{{ $usuario->name }}" name="name" class="">
        </div>


         <div style="display: flex; align-items: center;">

            <div class="mr-8">
                <label for="lastname1">Apellido Paterno </label>
                <span class="text-danger">*</span>
                <br>
                <input type="text" value="{{ $usuario->lastname1 }}" name="lastname1">
            </div>
            <div class="ml-3">
                <label for="lastname2">Apellido Materno </label>
                <span class="text-danger">*</span>
                <br>
                <input type="text" value="{{ $usuario->lastname2 }}" name="lastname2">
            </div>

        </div>
         <br>
        @if ($usuario->tutor)
        @else
        <div style="display: flex; align-items: center;">

            <div class="mr-8">
                <label for="cel">Celular</label>
                <br>
                <input type="text" value="{{ $usuario->Celular }}" name="Celular">
            </div>
            <div class="ml-3">
                <label for="email">Correo electrónico</label>
                <br>
                <input type="text" value="{{ $usuario->email }}" name="email">
            </div>

        </div>
        @endif
        <div class="mt-3" style="display: flex; align-items: center;">

            <div class="mr-8">
                <label for="name">Fecha de nacimiento</label>
                <br>
                <input type="date" value="{{ $usuario->fechadenac }}" name="fechadenac">
            </div>

            <div class="ml-7">
                <label for="name">Cedula de identidad</label>
                <br>
                <input type="text" value="{{ $usuario->CI }}" name="CI">
            </div>


        </div>

        <div class="mt-3" style="display: flex; align-items: center;">
            <div class="mr-8">
                <label for="name">Pais:</label>
                <br>
                <input type="text" value="{{ $usuario->PaisReside }}" name="PaisReside">
            </div>
            <div class="ml-3">
                <label for="name">Ciudad:</label>
                <br>
                <input type="text" value="{{ $usuario->CiudadReside }}" name="CiudadReside">
            </div>
        </div>


        <br>

        @if ($usuario->tutor)


        <hr>
        <h4>Datos Personales Tutor</h4>
        <label for="name">Nombre Completo del Tutor:</label>

        <input type="text" placeholder="Nombre" name="nombreT" value="{{ $usuario->tutor->nombreTutor ?? ''}}">
        <input type="text" placeholder="Apellido Paterno" name="appT" value="{{ $usuario->tutor->appaternoTutor ?? ''}}">
        <input type="text" placeholder="Apellido Materno" name="apmT" value="{{ $usuario->tutor->apmaternoTutor ?? ''}}">
        <br>
        <label for="name">Cedula Identidad Tutor:</label>

        <input type="text" placeholder="Cedula de Identidad Tutor" name="CIT"  value="{{ $usuario->tutor->CI ?? ''}}">
        <br>
        <label for="name">DirecciÓn:</label>
        <input type="text" placeholder="Dirección" name="direccion"  value="{{ $usuario->tutor->Direccion ?? ''}}">
        <br>

        <label for="name">Celular:</label>
        <input type="text" value="{{ $usuario->Celular }}" name="Celular">
        <br>
        <label for="name">Correo electrónico:</label>
        <input type="text" value="{{ $usuario->email }}" name="email">

        @endif

        <br>
      @if (auth()->user()->hasRole('Docente') )

      @foreach ($atributosD as $atributosD)
      <div style="display: flex; align-items: center;">

        <div>
            <label for="name">Formación Academica:</label>
            <input type="text" placeholder="Formación Academica" name="formacion" value="{{ $atributosD->formacion ?? ''}}">
        </div>
        <div>
            <label for="name">Experiencia Laboral:</label>
            <input type="text" placeholder="Experiencia Laboral" name="Especializacion"  value="{{ $atributosD->Especializacion ?? ''}}">
        </div>
        <div>
                <label for="name">Especialización:</label>
            <input type="text"  placeholder="Especialización" name="ExperienciaL" value="{{ $atributosD->ExperienciaL ?? '' }}">
        </div>
        </div>


      @endforeach
      @endif
      <label for="name">Cambiar Contraseña:</label>

      <div class="input-group">
        <input type="password" class="form-control" id="password" placeholder="Ingrese Nueva Contraseña" name="password">
        <div class="input-group-append">
          <button class="btn btn-outline-secondary" type="button" id="togglePassword">
            <i class="fas fa-eye" id="eyeIcon"></i>
          </button>
        </div>
      </div>
      <br><br>
      <input class="btn btn-warning" type="submit" value="Guardar Cambios">

    </form>

    @if ($errors->any())
    @foreach ($errors->all() as $error)
        <h2 class="bg-danger alert-danger">{{$error}}</h2>
    @endforeach
    @endif

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif


<script>
    // Función para alternar la visibilidad de la contraseña
    document.getElementById("togglePassword").addEventListener("click", function() {
      var passwordInput = document.getElementById("password");
      var eyeIcon = document.getElementById("eyeIcon");

      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
      } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
      }
    });
  </script>

@endsection


@include('layout')
