@section('titulo')
    Asignar Cursos
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
  <li class="nav-item active">
    <a class="nav-link active" href="{{route('AsignarCurso')}}">
      <i class="ni ni-key-25 text-info"></i> Asignar Cursos
    </a>
  </li>

</ul>
@endif

@endsection


@section('content')
    <form method="POST">
        @csrf
        <div class="card-body p-3">
            <div class="row">
                <div class="col-md-6 mb-md-0 mb-4">
                    <h3>Curso</h3>
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                        <select name="curso" id="" class="mb-0 bg-transparent border-0">
                            @foreach ($cursos as $cursos)
                                <option value="{{ $cursos->id }}">{{ $cursos->nombreCurso }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <h3>Estudiante</h3>
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                        <select name="estudiante" id="" class="mb-0 bg-transparent border-0">

                            @foreach ($estudiantes as $estudiantes)

                                <option value="{{ $estudiantes->id }}">
                                    {{ $estudiantes->name . ' ' . $estudiantes->lastname1 . ' ' . $estudiantes->lastname2 }}
                                </option>

                            @endforeach

                        </select>
                    </div>
                </div>
            </div>
            <br><br>

            <input class="btn btn-lg btn-success" type="submit" value="INCRIBIR ALUMNO">

        </div>
    </form>

    @if ($errors->any())
    @foreach ($errors->all() as $error)
        <h2 class="bg-danger alert-danger">{{$error}}</h2>
    @endforeach
    @endif
@endsection

@extends('layout')
