@section('titulo')
    Lista de Estudiantes

@endsection

@section('nav')
@if (auth()->user()->hasRole('Administrador'))
<ul class="navbar-nav">
  <li class="nav-item">
    <a class="nav-link" href="{{route('Miperfil')}}">
      <i class="ni ni-circle-08 text-green"></i> Mi perfil
    </a>
  </li>
  <li class="nav-item ">
    <a class="nav-link " href="{{route('Inicio')}}">
      <i class="ni ni-tv-2 text-primary"></i> Mis Cursos
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link " href="{{route('ListaDocentes')}}">
      <i class="ni ni-single-02 text-blue"></i> Lista de Docentes
    </a>
  </li>
  <li class="nav-item active">
    <a class="nav-link active" href="{{route('ListaEstudiantes')}}">
      <i class="ni ni-single-02 text-orange"></i> Lista de Estudiantes
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link " href="./examples/tables.html">
      <i class="ni ni-bullet-list-67 text-red"></i> Aportes
    </a>
  </li>
  <li class="nav-item ">
    <a class="nav-link " href="{{route('AsignarCurso')}}">
      <i class="ni ni-key-25 text-info"></i> Asignar Cursos
    </a>
  </li>

</ul>
@endif

@endsection


@section('content')
<div class="col-lg-12 row">
    <div class="text-right">
        <a href="{{ route('CrearEstudianteMenor') }}" class="btn btn-sm btn-success">Crear Estudiante Menor
            o Especial</a>
    </div>
    <div class="text-right">
        <a href="{{ route('CrearEstudiante') }}" class="btn btn-sm btn-success">Crear Estudiante</a>
    </div>
    <form class="navbar-search navbar-search form-inline mr-3 d-none d-md-flex ml-lg-auto">
        <div class="input-group input-group-alternative">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
          </div>
          <input class="form-control" placeholder="Buscar" type="text">
        </div>
    </form>
</div>
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Nro</th>
                            <th scope="col">Nombre y Apellidos</th>
                            <th scope="col">Celular</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Edad</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($estudiantes as $estudiantes)
                            <tr>

                                <td scope="row">

                                    {{ $loop->iteration }}

                                </td>
                                <td scope="row">
                                    {{ $estudiantes->name }}
                                    {{ $estudiantes->lastname1 }}
                                    {{ $estudiantes->lastname2 }}
                                </td>
                                <td>
                                    {{ $estudiantes->Celular }}
                                </td>
                                <td>
                                    {{ $estudiantes->email }}
                                </td>
                                <td>
                                    {{$estudiantes->age()}}
                                </td>
                                <td>

                                    <a href="/user/{{ $estudiantes->id }}">Ver Mas</a>

                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>



@endsection

@include('layout')
