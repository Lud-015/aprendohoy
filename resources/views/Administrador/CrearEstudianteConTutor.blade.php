

@section('titulo')

Crear Estudiante Con tutor
@endsection


@section('nav')
<ul>

    <li>
        <a href="{{route('Inicio')}}" class="nav-link">Inicio</a>
    </li>
    <li>
        <a href="{{route('ListaEstudiantes')}}" class="nav-link">Lista de Estudiantes</a>
    </li>
</ul>

@endsection

@section('content')



<form method="post">
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
<label for="">Fecha de Nacimiento</label>
<input type="text" name="fechadenac">
<br>
<label for="">Pais Residencia</label>
<input type="text" name="PaisReside">
<br>
<label for="">Ciudad Residencia</label>
<input type="text" name="CiudadReside">
<br>
<br>
Informacion de Representante Legal
<br>
<br>
<label for="">Nombre Tutor</label>
<input type="text" name="nombreT">
<br>
<br>
<label for="">Apellido Paterno Tutor</label>
<input type="text" name="appT">
<br>
<br>
<label for="">Apellido Materno Tutor</label>
<input type="text" name="apmT">
<br>
<label for="">Celular Tutor</label>
<input type="text" name="CelularT">
<br>
<br>
<label for="">CI Tutor</label>
<input type="text" name="CIT">
<br>
<label for="">Correo Electronico Tutor</label>
<input type="text" name="email">
<br>
<br>
<input type="submit" value="Crear Estudiante">


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
