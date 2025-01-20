


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
                <a class="nav-link" href="{{ route('AsignarCurso') }}">
                    <i class="ni ni-key-25 text-info"></i> Asignación de Cursos
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
                <a class="nav-link" href="{{ route('AsignarCurso') }}">
                    <i class="ni ni-key-25 text-info"></i> Asignación de Cursos
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



        </ul>
    @endif
@endsection

@section('content')
<div class="border p-3">
<a href="javascript:history.back()" class="btn btn-primary">
    &#9668; Volver
</a>
<br>

<div class="recursoscrear-container">
<div class="title">

                <h2>Subir Recurso (Docente)</h2>
                <p>Curso: {{$curso->nombreCurso}}</p> <!-- Reemplaza "Curso de Ejemplo" con el nombre real del curso -->
            </div>

        <div class="form">
            <form method="POST" enctype="multipart/form-data" action="{{route('CrearRecursosPost', $curso->id)}}">
                <input type="text" value="{{$curso->id}}" name="cursos_id" hidden>
                @csrf
                <div class="form-group">
                    <label for="tituloRecurso" class="form-label">Título del Recurso:</label>
                    <input type="text" id="fileTitle" name="tituloRecurso" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="fileDescription" class="form-label">Descripción del Recurso:</label>
                    <br>
                    <textarea id="fileDescription" name="descripcionRecurso" rows="4" class="form-input" required></textarea>
                </div>
                <div class="form-group">
                    <label for="fileUpload" class="form-label">Seleccionar Archivo:</label>
                    <input type="file" id="fileUpload" name="archivo" class="form-input">
                </div>


                <h2>Elige el tipo de Recurso</h2>

                <div class="icon-gallery">

                    <div class="icon-option">
                        <img src="{{asset('resources/icons/word.png')}}" alt="word" data-value="word" height="50px" width: auto>
                        <p>Word</p>
                    </div>
                    <div class="icon-option">
                        <img src="{{asset('resources/icons/excel.png')}}" alt="excel" data-value="excel" height="50px">
                        <p>Excel</p>
                    </div>
                    <div class="icon-option">
                        <img src="{{asset('resources/icons/powerpoint.png')}}" alt="powerpoint" data-value="powerpoint" height="50px">
                        <p>PowerPoint</p>
                    </div>
                    <div class="icon-option">
                        <img src="{{asset('resources/icons/pdf.png')}}" alt="pdf" data-value="pdf" height="50px">
                        <p>PDF</p>
                    </div>
                    <div class="icon-option">
                        <img src="{{asset('resources/icons/archivos-adjuntos.png')}}" alt="archivos-adjuntos" data-value="archivos-adjuntos" height="50px">
                        <p>Archivos Adjuntos</p>
                    </div>
                    <div class="icon-option">
                        <img src="{{asset('resources/icons/doc.png')}}" alt="docs" data-value="docs" height="50px">
                        <p>Docs</p>
                    </div>
                    <div class="icon-option">
                        <img src="{{asset('resources/icons/forms.png')}}" alt="forms" data-value="forms" height="50px">
                        <p>Forms</p>
                    </div>
                    <div class="icon-option">
                        <img src="{{asset('resources/icons/drive.png')}}" alt="drive" data-value="drive" height="50px">
                        <p>Drive</p>
                    </div>
                    <div class="icon-option">
                        <img src="{{asset('resources/icons/youtube.png')}}" alt="youtube" data-value="youtube" height="50px">
                        <p>YouTube</p>
                    </div>
                    <div class="icon-option">
                        <img src="{{asset('resources/icons/kahoot.png')}}" alt="kahoot" data-value="kahoot" height="50px">
                        <p>Kahoot</p>
                    </div>
                    <div class="icon-option">
                        <img src="{{asset('resources/icons/canva.png')}}" alt="canva" data-value="canva" height="50px">
                        <p>Canva</p>
                    </div>
                    <div class="icon-option">
                        <img src="{{asset('resources/icons/zoom.png')}}" alt="zoom" data-value="zoom" height="50px">
                        <p>Zoom</p>
                    </div>
                    <div class="icon-option">
                        <img src="{{asset('resources/icons/meet.png')}}" alt="meet" data-value="meet" height="50px">
                        <p>Meet</p>
                    </div>
                    <div class="icon-option">
                        <img src="{{asset('resources/icons/teams.png')}}" alt="teams" data-value="teams" height="30px" width = "auto">
                        <p>Teams</p>
                    </div>
                    <div class="icon-option">
                        <img src="{{asset('resources/icons/enlace.png')}}" alt="enlace" data-value="enlace" height="50px">
                        <p>Enlace</p>
                    </div>
                    <div class="icon-option">
                        <img src="{{asset('resources/icons/imagen.png')}}" alt="imagen" data-value="imagen" height="50px">
                        <p>Imagen</p>
                    </div>
                    <div class="icon-option">
                        <img src="{{asset('resources/icons/video.png')}}" alt="video" data-value="video" height="50px">
                        <p>Video</p>
                    </div>
                    <div class="icon-option">
                        <img src="{{asset('resources/icons/audio.png')}}" alt="audio" data-value="audio" height="50px">
                        <p>Audio</p>
                    </div>
                    <!-- Agrega más opciones de iconos según sea necesario -->
                </div>
                <input id="input-seleccionado" type="text" name="tipoRecurso" value="" hidden >
                 <p id="icono-seleccionado">Seleccionado: Ninguno</p>

            <script>
                const iconOptions = document.querySelectorAll('.icon-option');
                const iconoSeleccionado = document.getElementById('icono-seleccionado');
                const inputSeleccionado = document.getElementById('input-seleccionado');
                iconOptions.forEach((option) => {
                    option.addEventListener('click', () => {
                        const valorSeleccionado = option.querySelector('img').getAttribute('data-value');
                        iconoSeleccionado.textContent = `Seleccionado: ${valorSeleccionado}`;
                        inputSeleccionado.value = valorSeleccionado;

                    });
                });
            </script>



                <button type="submit" class="form-button">Guardar</button>
            </form>
        </div>


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

<style>

        .recursoscrear-container {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin: 20px;
        }

        .title {
            text-align: left;
        }

        .task-form {
            width: 100%;
            max-width: 400px;
            text-align: left;
            margin-top: 20px;
        }

    .task-form h2 {
        margin-bottom: 20px;
        font-size: 24px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    input[type="text"],
    textarea,
    input[type="date"],
    input[type="number"],
    input[type="file"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    input[type="checkbox"] {
        margin-top: 5px;
    }

    button {
        background-color: #007BFF;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 18px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }
    .icon-option {
        text-align: center; /* Alinear el contenido al centro */
        width: 100px; /* Ancho fijo para todos los iconos */
    }

    .icon-option img {
        height: 50px; /* Altura fija para todos los iconos */
        width: auto; /* Hacer que el ancho se ajuste automáticamente */
    }
</style>


</div>
@endsection

@include('layout')

