{{-- <link rel="stylesheet" href="{{ asset('assets/css/crear.css') }}" --}}
{{-- <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}"> --}}

@section('titulo')
    Crear Estudiante
@endsection



@section('content')

    <div class="col-xl-12">
        <a href="{{ route('ListaEstudiantes') }}" class="btn btn-primary">
            &#9668; Volver
        </a>
        <br>
        <br>
        <a href="{{ route('CrearEstudianteMenor') }}" class="btn btn-sm btn-success">Crear Estudiante con Representante
            Legal</a>
    </div>

    <div class="form col-12  mb-3 ">
        <hr>

        <form class="form" method="post" action="{{ route('CrearEstudiantePost') }}">
            @csrf
            <div class="form-group">
                <label for="name">Nombre</label>
                <span class="text-danger">*</span>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control custom-width">
            </div>
            <div class="mr-10 mt-3 mb-3" style="display: flex; align-items: center;">

                <div class="mr-8">
                    <label for="lastname1">Apellido Paterno</label>
                    <span class="text-danger">*</span>
                    <input type="text" name="lastname1" value="{{ old('lastname1') }}" class="form-control w-auto">
                </div>

                <div class="ml-3">
                    <label for="lastname2">Apellido Materno</label>
                    <span class="text-danger">*</span>
                    <input type="text" name="lastname2" value="{{ old('lastname2') }}" class="form-control w-auto">
                </div>
            </div>
            <div class="mr-10 mt-3 mb-3" style="display: flex; align-items: center;">

                <div class="mr-8">
                    <label for="CI">CI Estudiante</label>
                    <span class="text-danger">*</span>

                    <input type="text" name="CI" value="{{ old('CI') }}" class="form-control w-auto">
                </div>

                <div class="ml-3">
                    <label for="Celular">Número de Celular</label>
                    <span class="text-danger">*</span>
                    <input type="text" name="Celular" value="{{ old('Celular') }}" class="form-control w-auto">
                </div>
            </div>

            <div class="mr-10 mt-3 mb-3" style="display: flex; align-items: center;">

                <div class="form-group">
                    <label for="fechadenac">Fecha de Nacimiento</label>
                    <span class="text-danger">*</span>

                    <input type="date" name="fechadenac" value="{{ old('fechadenac') }}" class="form-control w-auto">
                </div>
            </div>

            <div class="mr-10 mt-3 mb-3" style="display: flex; align-items: center;">

                <div class="mr-8">
                    <label for="PaisReside">Pais de Residencia (Opcional)</label>
                    <input type="text" name="PaisReside" value="{{ old('PaisReside') }}" class="form-control w-auto">
                </div>

                <div class="ml-3">
                    <label for="CiudadReside">Ciudad de Residencia (Opcional)</label>
                    <input type="text" name="CiudadReside" value="{{ old('CiudadReside') }}"
                        class="form-control w-auto">
                </div>
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <span class="text-danger">*</span>
                <input type="text" name="email" value="{{ old('email') }}" class="form-control custom-width">
            </div>

            <input type="submit" value="Guardar" class="btn btn-primary">
        </form>

        <style>
            .custom-width {
                width: 50%;
                height: 50px;
            }
        </style>

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


    </div>
@endsection

@include('layout')
