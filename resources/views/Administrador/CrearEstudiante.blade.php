{{-- <link rel="stylesheet" href="{{ asset('assets/css/crear.css') }}" --}}
{{-- <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}"> --}}

@section('titulo')
    Crear Estudiante
@endsection

@section('nav')
    <nav class="navbar">
        <a href="{{ route('Inicio') }}" class="nav-link">Inicio</a>
        <a href="{{ route('ListaEstudiantes') }}" class="nav-link">Lista de Estudiantes</a>
        <a href="#" class="nav-link">Crear Estudiante</a>
    </nav>
@endsection

@section('content')


    <div class="form col-12  mb-3 ">
        <b>Tiene Representante Legal</b>
        <input type="checkbox" name="representante" id="check" value="1" onchange="javascript:showContent()" />
        <hr>
        <form class="" method="post">
            @csrf
            <!-- Campos del formulario -->
            <div class="flex-row">
            <label for="name">Nombre</label>
            <input type="text" name="name">
            <br>
            <label for="lastname1">Apellido Paterno</label>
            <input type="text" name="lastname1">
            <br>
            <label for="lastname2">Apellido Materno</label>
            <input type="text" name="lastname2">
            <br>
            <label for="CI">CI</label>
            <input type="text" name="CI">
            <br>
            <label for="Celular">Celular</label>
            <input type="text" name="Celular">
            <br>
            <label for="fechadenac">Fecha de Nacimiento</label>
            <input type="text" name="fechadenac">
            <br>
            <label for="">Pais Residencia</label>
            <input type="text" name="PaisReside">
            <br>
            <label for="">Ciudad Residencia</label>
            <input type="text" name="CiudadReside">
            <br>
            <label for="email">Correo Electrónico</label>
            <input type="text" name="email">
            <br>
        </div>
            <div class="flex-row" id="content" style="display: none;">
            <h4>
            Informacion de Representante Legal
            </h4>
            <label for="">Nombre Tutor</label>
            <input type="text" name="nombreT">
            <br>
            <label for="">Apellido Paterno Tutor</label>
            <input type="text" name="appT">
            <br>
            <label for="">Apellido Materno Tutor</label>
            <input type="text" name="apmT">
            <br>
            <label for="">Celular Tutor</label>
            <input type="text" name="CelularT">
            <br>
            <label for="">CI Tutor</label>
            <input type="text" name="CIT">
            <br>
            </div>

            <input type="submit" value="Crear Estudiante" class="btn-crear">
        </form>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <script type="text/javascript">
        function showContent() {
            element = document.getElementById("content");
            check = document.getElementById("check");
            if (check.checked) {
                element.style.display='block';
            }
            else {
                element.style.display='none';
            }
        }
    </script>


@endsection

@include('layout')
