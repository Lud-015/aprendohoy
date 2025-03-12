
@section('titulo')
Crear Foro
@endsection





@section('content')
<div class="border p-3">
<a href="javascript:history.back()" class="btn btn-primary">
    &#9668; Volver
</a>
<br>
<div class="form col-10  mb-10 ">
    <form method="post" action="{{route('CrearForoPost', $cursos->id)}}">
        @csrf
        <!-- Campos del formulario -->
        <input type="text" name="curso_id" value="{{$cursos->id}}" hidden>
        <label for="name">Nombre Foro</label>
        <input type="text" name="nombreForo">
        <br>
        <label for="name">Subtítulo Foro</label>
        <input type="text" name="SubtituloForo">
        <br>
        <label for="descripcion">Descripción del foro</label>
        <br>
        <textarea id="" cols="100" rows="10" name="descripcionForo"></textarea>
        <br>
        <br>
        <label for="fechadenac">Fecha de Finalización</label>
        <input type="date" name="fechaFin">
        <br>
        <input class="btn btn-success" type="submit" value="Guardar" class="btn-crear">
        <br><br>
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
@endsection


@include('layout')
