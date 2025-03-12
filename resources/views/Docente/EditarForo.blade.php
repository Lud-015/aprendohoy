
@section('titulo')
Editar Foro
@endsection


@section('content')
<div class="border p-3">
<a href="javascript:history.back()" class="btn btn-primary">
    &#9668; Volver
</a>
<br>
<div class="form col-10  mb-10 ">
    <form method="post" action="{{route('EditarForoPost', $foro->id)}}">
        @csrf

        <input type="text" name="idForo" value="{{$foro->id}}" hidden>

        <input type="text" name="curso_id" value="{{$foro->cursos_id}}" hidden>
        <!-- Campos del formulario -->
        <label for="name">Nombre Foro</label>
        <input type="text" name="nombreForo" value="{{$foro->nombreForo}}">
        <br>
        <label for="name">Subtitulo Foro</label>
        <input type="text" name="SubtituloForo" value="{{$foro->SubtituloForo}}">
        <br>
        <label for="lastname1">Descripcion del foro</label>
        <br>
        <textarea id="" cols="100" rows="10" name="descripcionForo" >
            {{$foro->descripcionForo}}
        </textarea>
        <br>
        <br>
        <label for="fechadenac">Fecha de Finalizacion</label>
        <input type="date" name="fechaFin" value="{{$foro->fechaFin}}">
        <br>
        <input type="submit" value="Guardar Cambios" class="btn-crear">
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
