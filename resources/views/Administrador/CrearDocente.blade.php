

@section('titulo')

Crear Docente

@endsection




@section('content')
<div class="border p-3">
<a href="{{ route('ListaDocentes') }}" class="btn btn-primary">
    &#9668; Volver
</a>
<br>
<br>
<style>
    .custom-width {
        width: 150%;
    }
</style>
<div class="form-group col-xl-12">
<form  method="post" action="{{route('CrearDocentePost')}}">
@csrf
@if (auth()->user()->hasRole('Administrador'))
    <div class="">
        <label for="name">Nombre Docente</label>
                <span class="text-danger">*</span>
        <input type="text" name="name" value="{{ old('name')}}" class="form-control w-50">
    </div>

    <div class="mr-10 mt-3 mb-3" style="display: flex; align-items: center;">
        <div class="mr-8">
            <label for="lastname1">Apellido Paterno Docente</label>
            <span class="text-danger">*</span>
            <input type="text" name="lastname1"  value="{{ old('lastname1')}}" class="form-control w-auto">
        </div>
        <div class="ml-3">
            <label for="lastname2">Apellido Materno Docente</label>
            <span class="text-danger">*</span>
            <input type="text" name="lastname2" value="{{ old('lastname2')}}" class="form-control w-auto">
        </div>
    </div>

    <div class="mt-3 mb-3" style="display: flex; align-items: center;">

    <div class="mr-8">
        <label for="CI">Número de CI Docente</label>
        <span class="text-danger">*</span>
        <input type="text" name="CI" value="{{ old('CI')}}" class="form-control W-auto">
    </div>

    <div class="ml-3">
        <label for="Celular">Número de Celular</label>
        <span class="text-danger">*</span>
        <input type="text" name="Celular" value="{{ old('Celular')}}"  class="form-control W-auto">
    </div>
    </div>

    <div class="mt-3 mb-3" style="display: flex; align-items: center;">

    <div class="mr-8">
        <label for="fechadenac">Fecha de Nacimiento</label>
        <span class="text-danger">*</span>
        <input type="date" name="fechadenac" value="{{ old('fechadenac')}}" class="form-control W-auto">
    </div>

    </div>


    <div class="mt-3 mb-3" style="display: flex; align-items: center;">

    <div class="mr-8">
        <label for="PaisReside">Pais de Residencia (Opcional)</label>
        <input type="text" name="PaisReside" value="{{ old('PaisReside')}}" class="form-control w-auto">
    </div>

    <div class="ml-3">
        <label for="CiudadReside">Ciudad de Residencia (Opcional)</label>
        <input type="text" name="CiudadReside" value="{{ old('CiudadReside')}}" class="form-control w-auto">
    </div>
    </div>
    <div class="mt-3 mb-3" style="display: flex; align-items: center;">

    <div class="mr-8">
        <label for="email">Correo Electrónico</label>
        <span class="text-danger">*</span>
        <input type="text" name="email" value="{{ old('email')}}" class="form-control custom-width">
    </div>
    </div>

    <input type="submit" value="Guardar" class="btn btn-primary">
</form>




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
</div>
@endsection


@include('layout')



