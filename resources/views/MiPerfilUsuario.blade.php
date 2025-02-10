@section('titulo')
    Mi Perfil
@endsection



@section('nav')
    @if (auth()->user()->hasRole('Administrador'))
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link active" href="{{ route('Miperfil') }}">
                    <i class="ni ni-circle-08 text-green"></i> Mi perfil
                </a>
            </li>
            <li class="nav-item   ">
                <a class="nav-link   " href="{{ route('Inicio') }}">
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
                <a class="nav-link " href="{{ route('aportesLista') }}">
                    <i class="ni ni-bullet-list-67 text-red"></i> Aportes
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
            <li class="nav-item   ">
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
                    <i class="ni ni-key-25 text-info"></i> Asignación Cursos
                </a>
            </li>

        </ul>
    @endif

    @if (auth()->user()->hasRole('Estudiante'))
        <ul class="navbar-nav ">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('Miperfil') }}">
                    <i class="ni ni-circle-08 text-green"></i> Mi perfil
                </a>
            </li>
            <li class="nav-item   ">
                <a class="nav-link   " href="{{ route('Inicio') }}">
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


<style>
    input[type="file"] {
        /* Ocultar el campo de entrada */
        position: absolute;
        clip: rect(0, 0, 0, 0);
        pointer-events: none;
    }

    /* Estilo personalizado para el botón de carga de archivo */
    .custom-file-upload {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
        background-color: #f7f7f7;
    }
</style>


@section('avatar')

<div class="container text-center">
    @php
        $avatarUrl = auth()->user()->avatar
            ? asset('storage/' . auth()->user()->avatar)
            : asset('./assets/img/user.png');
    @endphp

    <!-- Imagen de perfil -->
    <img id="avatar" src="{{ $avatarUrl }}" class="rounded-circle border border-secondary shadow-sm"
        alt="Avatar del usuario" height="150" width="150" data-toggle="modal" data-target="#avatarModal">

    <!-- Botón para abrir el modal -->

</div>

<!-- Modal para cambiar la foto -->
<div class="modal fade" id="avatarModal" tabindex="-1" role="dialog" aria-labelledby="avatarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="avatarModalLabel">Actualizar Foto de Perfil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body text-center">
                <!-- Vista previa de la imagen -->
                <div class="mb-8">
                    <img id="preview" class="rounded-circle border border-secondary mb-3"
                    src="{{ $avatarUrl }}" width="120" height="120">
                </div>

                <!-- Formulario para subir la imagen -->
                <form class="my-5" method="POST" action="{{ route('avatar') }}" enctype="multipart/form-data" id="uploadForm">
                    @csrf
                    <input type="hidden" name="id" value="{{ auth()->user()->id }}">

                    <!-- Input para seleccionar imagen -->
                    <div class="custom-file mb-3">
                        <input type="file" class="custom-file-input" id="avatarInput" name="avatar" accept="image/*">
                        <label class="custom-file-label" for="avatarInput">Elegir imagen...</label>
                    </div>

                    <!-- Botón para subir la imagen -->
                    <button type="submit" class="btn btn-success btn-block">
                        Subir Imagen
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script para vista previa -->
<script>
    document.getElementById('avatarInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            if (!file.type.startsWith('image/')) {
                alert('Por favor, selecciona una imagen válida.');
                return;
            }

            // Mostrar la vista previa de la imagen
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection

@section('contentPerfil')
    <div class="row">

    </div>
    <div class="text-center mt-5">
        <h3>
            {{ auth()->user()->name }} {{ auth()->user()->lastname1 }}<span class="font-weight-light"></span>
        </h3>


        <div class="h5 font-weight-300">
            {{ auth()->user()->roles->pluck('name')[0] }}
        </div>

        <div class="h5 mt-4">

        </div>
        <i class="ni location_pin mr-2"></i>{{ auth()->user()->CiudadReside }}, {{ auth()->user()->PaisReside }}
        <div>
            <i class="ni education_hat mr-2"></i>


        </div>

    </div>
@endsection

@section('container')
    <div class="flex flex-wrap container w-full mx-auto pt-20">
        <div class="flex flex-wrap w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">

            <div class="m-4 w-full sm:w-1/2 lg:w-1/3">
                <div class="rounded-lg border bg-white px-4 pt-8 pb-10 shadow-lg">
                    <div class="mx-auto w-36 rounded-full">
                        @if (auth()->user()->avatar == '')
                            <img id="avatar" class="mx-auto h-auto w-full aspect-square rounded-full"
                                src="{{ asset('./assets/img/user.png') }}" alt="">
                        @else
                            <img id="avatar" class="mx-auto h-auto w-full aspect-square rounded-full"
                                src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="">
                        @endif

                        <form method="POST" class="" enctype="multipart/form-data" id="uploadForm">
                            @csrf
                            <div class="align-content-start">
                                <input type="text" name="id" value="{{ auth()->user()->id }}" hidden readonly
                                    disabled>
                                <label for="avatarInput" class="btn button"><i class="fa fa-image"></i></label>
                                <input type="file" id="avatarInput" name="avatar" accept="image/*">
                                <label for="submitInput" class="btn button">
                                    <i class="fa fa-upload"></i>
                                    <input id="submitInput" type="submit" onclick="resizeAndSubmit()"
                                        style="display: none;">
                                </label>
                            </div>
                        </form>

                        <canvas id="canvas" style="display: none;"></canvas>

                    </div>
                    <h1 class="my-1 text-center text-xl font-bold leading-8 text-gray-900">{{ auth()->user()->name }}
                        {{ auth()->user()->lastname1 }} {{ auth()->user()->lastname2 }}</h1>
                    <h3 class="font-lg text-semibold text-center leading-6 text-gray-600">
                        {{ auth()->user()->roles->pluck('name')[0] }}</h3>
                    <ul
                        class="mt-3 divide-y rounded bg-gray-100 py-2 px-3 text-gray-600 shadow-sm hover:text-gray-700 hover:shadow">
                        <li class="flex items-center py-3 text-sm">
                            <a href="{{ route('EditarperfilIndex', [auth()->user()->id]) }}"
                                class="rounded-full bg-blue-200 py-1 px-2 text-xs font-medium text-yellow-700">Editar</a>
                            <a href="{{ route('CambiarContrasena', [auth()->user()->id]) }}"
                                class="ml-auto rounded-full bg-blue-200 py-1 px-2 text-xs font-medium text-yellow-700">Cambiar
                                contraseña</a>
                        </li>

                        <li class="flex items-center py-3 text-sm">
                            <span>Celular</span>
                            <span class="ml-auto">{{ auth()->user()->Celular }}</span>
                        </li>
                        <li class="flex items-center py-3 text-sm">
                            <span>Se unió el</span>
                            <span class="ml-auto">{{ auth()->user()->created_at }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="m-4 w-full sm:w-1/2 lg:w-1/3">
                <div class="rounded-lg border bg-white px-4 pt-8 pb-10 shadow-lg">
                    <h1 class="my-1 text-center text-xl font-bold leading-8 text-gray-900">Más Información</h1>
                    <ul
                        class="mt-3 divide-y rounded bg-gray-100 py-2 px-3 text-gray-600 shadow-sm hover:text-gray-700 hover:shadow">
                        <li class="flex items-center py-3 text-sm">
                            <span>País origen</span>
                            <span class="ml-auto">{{ auth()->user()->PaisReside }}</span>
                        </li>
                        <li class="flex items-center py-3 text-sm">
                            <span>Ciudad origen</span>
                            <span class="ml-auto">{{ auth()->user()->CiudadReside }}</span>
                        </li>
                        <li class="flex items-center py-3 text-sm">
                            <span>Correo Electrónico: </span>
                            <span class="ml-auto">{{ auth()->user()->email }}</span>
                        </li>

                        @if (auth()->user()->hasRole('Docente'))
                            @forelse ($atributosD as $atributo)
                                <li class="flex items-center py-3 text-sm">
                                    <span>Profesión: </span>
                                    <span class="ml-auto">{{ $atributo->formacion }}</span>
                                </li>
                                <li class="flex items-center py-3 text-sm">
                                    <span>Especialización: </span>
                                    <span class="ml-auto">{{ $atributo->Especializacion }}</span>
                                </li>
                                <li class="flex items-center py-3 text-sm">
                                    <span>Experiencia Laboral: </span>
                                    <span class="ml-auto">{{ $atributo->ExperienciaL }}</span>
                                </li>
                            @empty
                            @endforelse

                            <li class="flex items-center py-3 text-sm">
                                <span>Hoja de vida: </span>
                                @if (auth()->user()->cv_file == '')
                                    <h3>Aún no se ha subido una hoja de vida</h3>
                                @else
                                    <a href="{{ asset('storage/' . auth()->user()->cv_file) }}">Ver hoja de vida</a>
                                @endif
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            @if (auth()->user()->hasRole('Docente'))
                <div class="m-4 w-full lg:w-1/2">
                    <div class="rounded-lg border bg-white px-8 pt-10 pb-12 shadow-lg">
                        <h1 class="my-1 text-center text-xl font-bold leading-8 text-gray-900">Tus últimas 4 experiencias
                            laborales</h1>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Lugar de Trabajo</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Cargo</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fecha Inicio</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fecha Fin</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Contacto de Referencia</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($trabajos as $trabajo)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $trabajo->empresa }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $trabajo->cargo }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $trabajo->fecha_inicio }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $trabajo->fecha_fin }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $trabajo->contacto_ref }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"
                                            class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">No se han
                                            registrado tus trabajos más recientes</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </div>

@endsection


@section('content')

    <div class="card bg-secondary shadow">
        <div class="card-header bg-white border-0" style="margin: 10px;">
            <div class="row align-items-center">
                <div class="col-8">
                    <h3 class="mb-0">Mi perfil</h3>
                </div>
                <div style="display: flex; align-items: center;">

                    <a href="{{ route('EditarperfilIndex', [auth()->user()->id]) }}"
                        class="btn btn-sm btn-primary">Editar</a>
                    <a href="{{ route('CambiarContrasena', [auth()->user()->id]) }}"
                        class="btn btn-sm btn-primary">Cambiar contraseña</a>
                </div>

            </div>
        </div>
        <div class="card-body" style="margin: 10px;">
            <form>
                <h6 class="heading-small text-muted mb-4">Información de usuario</h6>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-username">Nombre</label>
                                <input type="text" disabled id="input-username"
                                    class="form-control form-control-alternative" placeholder="Username"
                                    value="{{ auth()->user()->name }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-email">Correo Electronico</label>
                                <input type="email" disabled id="input-email"
                                    class="form-control form-control-alternative"
                                    placeholder="{{ auth()->user()->email }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-first-name">Apellido Paterno
                                </label>
                                <input type="text" disabled id="input-first-name"
                                    class="form-control form-control-alternative" placeholder="First name"
                                    value="{{ auth()->user()->lastname1 }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-last-name">Apellido Materno</label>
                                <input type="text" disabled id="input-last-name"
                                    class="form-control form-control-alternative" placeholder="Last name"
                                    value="{{ auth()->user()->lastname2 }}">
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-4" />
                <!-- Address -->
                <h6 class="heading-small text-muted mb-4">Información de Contacto </h6>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label" for="input-address">Celular</label>
                                <input id="input-address" class="form-control form-control-alternative" disabled
                                    placeholder="Home Address" value="{{ auth()->user()->Celular }}">
                            </div>
                            @if (auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Docente'))
                                <div class="form-group">
                                    <label class="form-control-label" for="input-address">Hoja de Vida</label>
                                </div>
                                @if (auth()->user()->cv_file == '')
                                    <h3>Aún no se ha subido una hoja de vida</h3>
                                @else
                                    <a href="{{ asset('storage/' . auth()->user()->cv_file) }}"> Ver hoja de vida </a>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            {{-- <div class="form-group">
                <label class="form-control-label" for="input-city">Ciudad</label>
                <input type="text" id="input-city" class="form-control form-control-alternative" placeholder="City" value="New York">
              </div> --}}
                        </div>


                    </div>
                </div>
        </div>
        {{-- <hr class="my-4" /> --}}
        <!-- Description -->
        {{-- <h6 class="heading-small text-muted mb-4">About me</h6>
        <div class="pl-lg-4">
          <div class="form-group">
            <label>About Me</label>
            <textarea rows="4" class="form-control form-control-alternative" placeholder="A few words about you ...">A beautiful Dashboard for Bootstrap 4. It is Free and Open Source.</textarea>
          </div>
        </div> --}}
        </form>
    </div>

@endsection

<script>
    function resizeAndSubmit() {
        const fileInput = document.getElementById('avatarInput');
        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');

        const file = fileInput.files[0];
        const reader = new FileReader();

        reader.onload = function(event) {
            const img = new Image();
            img.onload = function() {
                const MAX_WIDTH = 512;
                const MAX_HEIGHT = 512;
                let width = img.width;
                let height = img.height;

                if (width > height) {
                    if (width > MAX_WIDTH) {
                        height *= MAX_WIDTH / width;
                        width = MAX_WIDTH;
                    }
                } else {
                    if (height > MAX_HEIGHT) {
                        width *= MAX_HEIGHT / height;
                        height = MAX_HEIGHT;
                    }
                }

                canvas.width = width;
                canvas.height = height;

                ctx.drawImage(img, 0, 0, width, height);
                const resizedImageData = canvas.toDataURL('image/jpeg');

                // Crear un nuevo FormData y agregar la imagen redimensionada
                const formData = new FormData(document.getElementById('uploadForm'));
                const resizedImageBlob = dataURItoBlob(resizedImageData);
                formData.set('avatar', resizedImageBlob, 'avatar.jpg');

                // Enviar el formulario al servidor
                fetch('tu/ruta/de/envio', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        // Manejar la respuesta del servidor
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            };

            img.src = event.target.result;
        };

        reader.readAsDataURL(file);
    }

    function dataURItoBlob(dataURI) {
        const byteString = atob(dataURI.split(',')[1]);
        const mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
        const ab = new ArrayBuffer(byteString.length);
        const ia = new Uint8Array(ab);

        for (let i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }

        return new Blob([ab], {
            type: mimeString
        });
    }
</script>

<script>
    document.getElementById('avatarInput').addEventListener('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('avatarForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally

        // You can add your code here to save the avatar, for example, sending it to a server via AJAX.
        // Here's a simple example:
        var avatarDataUrl = document.getElementById('avatar').src;
        console.log('Avatar data URL:', avatarDataUrl);
    });
</script>




@if (auth()->user()->hasRole('Administrador'))
    @include('PerfilUsuarioLayout')
@endif

@if (auth()->user()->hasRole('Docente') || auth()->user()->hasRole('Estudiante'))
    @include('FundacionPlantillaUsu.index')
@endif
