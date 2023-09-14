{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foro</title>
    <link rel="stylesheet" href="{{ asset('assets/css/foro.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">

</head>
<body> --}}


@section('titulo')

Foro de Discusión de {{$foro->nombreForo}}

@endsection


@section('nav')
    @if (auth()->user()->hasRole('Administrador'))
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Miperfil') }}">
                    <i class="ni ni-circle-08 text-green"></i> Mi perfil
                </a>
            </li>
            <li class="nav-item  active ">
                <a class="nav-link  active " href="{{ route('Inicio') }}">
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
            <li class="nav-item">
                <a class="nav-link" href="{{ route('AsignarCurso') }}">
                    <i class="ni ni-key-25 text-info"></i> Asignar Cursos
                </a>
            </li>

        </ul>
    @endif

    @if (auth()->user()->hasRole('Docente'))
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Miperfil') }}">
                    <i class="ni ni-circle-08 text-green"></i> Mi perfil
                </a>
            </li>
            <li class="nav-item  active ">
                <a class="nav-link  active " href="{{ route('Inicio') }}">
                    <i class="ni ni-tv-2 text-primary"></i> Mis Cursos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="./examples/tables.html">
                    <i class="ni ni-bullet-list-67 text-red"></i> Aportes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('AsignarCurso') }}">
                    <i class="ni ni-key-25 text-info"></i> Asignar Cursos
                </a>
            </li>

        </ul>
    @endif

    @if (auth()->user()->hasRole('Estudiante'))
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Miperfil') }}">
                    <i class="ni ni-circle-08 text-green"></i> Mi perfil
                </a>
            </li>
            <li class="nav-item  active ">
                <a class="nav-link  active " href="{{ route('Inicio') }}">
                    <i class="ni ni-tv-2 text-primary"></i> Mis Cursos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="./examples/tables.html">
                    <i class="ni ni-bullet-list-67 text-red"></i> Mis Aportes
                </a>
            </li>


        </ul>
    @endif
@endsection

@section('content')



    <textarea class="col-12" id="" cols="100" rows="10" readonly style="border: 0">

        {{$foro->descripcionForo}}

    </textarea>

    <br>
    @foreach ($forosmensajes as $forosmensajes)
    @if ($forosmensajes->foro_id == $foro->id)

    <div class="card-body">

        <div class="comment shadow">
            <h5 class="author">{{$forosmensajes->estudiantes->name}} {{$forosmensajes->estudiantes->lastname1}} {{$forosmensajes->estudiantes->lastname2}} - {{$forosmensajes->tituloMensaje}}</h5>
            <textarea name="" readonly id="" cols="100" rows="5" style="border: 0" >{{$forosmensajes->mensaje}}</textarea>
        </div>
    </div>
    @endif
    @endforeach

    <div class="card-body ">
    <!-- Formulario para agregar un comentario -->
    <form class="comment-form " method="POST">
        @csrf
        <input type="text" name="foro_id" value="{{$foro->id}}" hidden>
        <input type="text" name="estudiante_id" value="{{auth()->user()->id}}" hidden>
        <input type="text" name="tituloMensaje">
        <textarea name="mensaje" cols="100" rows="4" placeholder="Escribe tu comentario aquí" style="border: 0"></textarea>
        <br>
        <button type="submit">Publicar Comentario</button>
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

{{-- </body>
</html>
 --}}
