@section('titulo')
    Asignación de Cursos
@endsection

@section('nav')
@if (auth()->user()->hasRole('Administrador'))
<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('Miperfil') }}">
            <i class="ni ni-circle-08 text-green"></i> Mi perfil
        </a>
    </li>
    <li class="nav-item   ">
        <a class="nav-link   " href="{{ route('Inicio') }}">
            <i class="ni ni-tv-2 text-primary"></i> Inicio
        </a>
    </li>
    <li class="nav-item   ">
        <a class="nav-link  " href="{{ route('ListadeCursos') }}">
            <i class="ni ni-book-bookmark text-blue"></i> Lista de Cursos
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
    <a class="nav-link " href="{{ route('aportesLista') }}">
      <i class="ni ni-bullet-list-67 text-red"></i> Aportes
    </a>
  </li>
  <li class="nav-item active">
    <a class="nav-link active" href="{{route('AsignarCurso')}}">
      <i class="ni ni-key-25 text-info"></i> Asignación Cursos
    </a>
  </li>

</ul>

@endif

@if (auth()->user()->hasRole('Docente'))
<ul class="navbar-nav">
    <li class="nav-item">
            <a class="nav-link" href="{{ route('Miperfil') }}">
                <img src="{{ asset('assets/icons/user.png') }}" alt="Mi perfil Icon" style="width: 16px; margin-right: 10px;">
                Mi perfil
            </a>
        </li>
        <li class="nav-item active">
            <a class="nav-link active" href="{{ route('Inicio') }}">
                <img src="{{ asset('assets/icons/cursos.png') }}" alt "cursos" style="width: 16px; margin-right: 10px;">
                Mis Cursos
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ route('pagos') }}">
                <img src="{{ asset('assets/icons/pago.png') }}" alt "pago" style="width: 16px; margin-right: 10px;">
                Mis Aportes
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('AsignarCurso') }}">
                <img src="{{ asset('assets/icons/asignar.png') }}" alt="Asignar Cursos Icon" style="width: 16px; margin-right: 10px;">
                Asignación Cursos
            </a>
        </li>
    </ul>
@endif



@endsection


@section('content')
    <form method="POST" action="{{route('guardarNivel')}}">
        @csrf
        <div class="card-body p-3">
            <div class="row">
                <div class="col-md-6 mb-md-0 mb-4">
                    <h3>Ingrese nombre del nuevo nivel del curso</h3>
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">

                        <input type="text" name="nivel">

                    </div>
                </div>

            </div>
            <br><br>

            <input class="btn btn-lg btn-success" type="submit" value="Crear Nivel">

        </div>
    </form>

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
@endsection

@extends('layout')
