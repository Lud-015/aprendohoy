

@section('titulo')

Crear Docente

@endsection

   @section('nav')

        <a href="{{route('Inicio')}}" class="nav-link">Inicio</a>
        <a href="{{route('ListaEstudiantes')}}" class="nav-link">Lista de Estudiantes</a>
        <a href="#" class="nav-link">Crear Estudiante</a>
   @endsection


@section('content')
<form  method="post">
@csrf
@if (auth()->user()->hasRole('Administrador'))
<label for="">Nombre</label>
<input type="text" name="name">
<br>
<label for="" >Apellido Paterno</label>
<input type="text" name="lastname1">
<br>
<label for="">Apellido Materno</label>
<input type="text" name="lastname2">
<br>
<label for="">CI</label>
<input type="text" name="CI">
<br>
<label for="">Celular</label>
<input type="text" name="Celular">
<br>
<label for="">Fecha de Nacimiento</label>
<input type="date" name="fechadenac">
<br>
<label for="">Pais Residencia</label>
<input type="text" name="PaisReside">
<br>
<label for="">Ciudad Residencia</label>
<input type="text" name="CiudadReside">
<br>
<label for="">Correo Electronico</label>
<input type="text" name="email">
<br>
<input type="submit" value="Crear Docente">





</form>


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@else

<h1>NO ERES ADMINISTRADOR</h1>

@endif

@endsection


@include('layout')



