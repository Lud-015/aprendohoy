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
                    <i class="ni ni-key-25 text-info"></i> Asignar Cursos
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
                    <i class="ni ni-key-25 text-info"></i> Asignar Cursos
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

<h1>EDITAR PERFIL</h1>
    <form action="" method="POST" >
        @csrf
         <h4>Datos Personales</h4>
        <br>
        <input type="text" value="{{ auth()->user()->Celular }}" name="Celular">
        <br>
        <input type="text" value="{{ auth()->user()->fechadenac }}" name="fechadenac">
        <br>
        <br>


        <br>
      @if (auth()->user()->hasRole('Docente') or auth()->user()->hasRole('Administrador'))

      @foreach ($atributosD as $atributosD)

      <input type="text" placeholder="Formacion Academica" name="formacion" value="{{ $atributosD->formacion }}">
      <br>
      <input type="text" placeholder="Experiencia Laboral" name="Especializacion"  value="{{ $atributosD->Especializacion }}">
      <br>
      <input type="text"  placeholder="Especilaizacion" name="ExperienciaL" value="{{ $atributosD->ExperienciaL }}">
      <br>

      @endforeach
      @endif


      {{-- @if (auth()->user()->hasRole('Docente') or auth()->user()->hasRole('Administrador'))

      @foreach ($atributosD as $atributosD)

      <input type="text" placeholder="Formacion Academica" name="formacion" value="{{ $atributosD->formacion }}">
      <br>
      <input type="text" placeholder="Experiencia Laboral" name="Especializacion"  value="{{ $atributosD->Especializacion }}">
      <br>
      <input type="text"  placeholder="Especilaizacion" name="ExperienciaL" value="{{ $atributosD->ExperienciaL }}">
      <br>

      @endforeach
      @endif
 --}}




      <br><br>
      <br>
      <input type="password" name="confirmpassword" placeholder="Contraseña">
      <br><br>
      <input type="submit" value="EDITAR PERFIL">

    </form>

    @if ($errors->any())
    @foreach ($errors->all() as $error)
        <h2 class="bg-danger alert-danger">{{$error}}</h2>
    @endforeach
    @endif

@endsection


@include('layout')
