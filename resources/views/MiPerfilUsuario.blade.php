@section('titulo')
    Mi Perfil
@endsection

@section('nav2')
    <nav id="header"
        class=" fixed w-full z-12  shadow header header-main header-expand-lg header-transparent header-light py-5 mb-10">



        <div class="header-container">
            <div class="header-brand logo-izquierdo">
                <img src="{{ asset('./resources/img/logof.png') }}" class="w-24 lg:w-32 xl:w-40 h-auto">
            </div>
            <div class="header-brand logo-derecho">
                <img src="{{ asset('./resources/img/logoedin.png') }}" class="w-20 lg:w-24 xl:w-32 h-auto">
            </div>
        </div>
        <div class="w-full container mx-auto flex flex-wrap items-right mt-0 pt-3 mb-12 pb-20 md:pb-1">



            <div class=" lg:hidden ml-10">
                <button id="nav-toggle"
                    class="flex items-center px-3 py-2 border rounded text-blue-500 border-blue-200 hover:text-gray-900 hover:border-teal-500 appearance-none focus:outline-none">
                    <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <title>Menu</title>
                        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                    </svg>
                </button>
            </div>



            <div class="w-full lg:flex lg:items-center  bg-white z-10" id="nav-content">
                <div class="flex relative pull-right pl-2 pr-2 md:pr-0 ">

                    <div class="list-reset lg:flex flex-1 items-center px-4 mr-6 my-2 md:my-0 ">
                        <button id="userButton" class="flex items-center focus:outline-none mr-3">
                            @if (auth()->user()->avatar == '')
                                <img class="w-8 h-8 rounded-full mr-4" src="{{ asset('./assets/img/user.png') }}"
                                    alt="Avatar of User">
                            @else
                                <img class="w-8 h-8 rounded-full mr-4"
                                    src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar of User">
                            @endif
                            <span class="hidden md:inline-block atma">Bienvenid@, {{ auth()->user()->name }}
                                {{ auth()->user()->lastname1 }} </span>
                            <svg class="pl-2 h-2" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129"
                                xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129">
                                <g>
                                    <path
                                        d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z" />
                                </g>
                            </svg>
                        </button>
                        <div id="userMenu"
                            class="bg-white rounded shadow-md mt-2 absolute mt-12 top-0 right-0 min-w-full overflow-auto z-30 invisible">
                            <ul class="list-reset">
                                <li><a href="{{ route('Miperfil') }}"
                                        class="px-4 py-2 block text-gray-900 hover:bg-gray-400 no-underline hover:no-underline">Mi
                                        perfil</a></li>
                                <li><a href="#"
                                        class="px-4 py-2 block text-gray-900 hover:bg-gray-400 no-underline hover:no-underline">Notificaciones</a>
                                </li>
                                <li>
                                    <hr class="border-t mx-2 border-gray-400">
                                </li>
                                <li><a href="{{ route('logout') }}"
                                        class="px-4 py-2 block text-gray-900 hover:bg-gray-400 no-underline hover:no-underline">Cerrar
                                        Sesion</a>
                                </li>
                            </ul>
                        </div>
                    </div>



                </div>

                <ul class="list-reset lg:flex flex-1 items-center px-4 md:px-0 ">
                    <li class="mr-6 my-2 md:my-0">
                        <a href="{{ route('Inicio') }}"
                            class="block py-1 md:py-3 pl-1 align-middle text-blue-900 no-underline hover:text-gray-900 border-b-2 border-orange-600 hover:border-orange-600">
                            <i class="fas fa-home fa-fw mr-3 text-blue-900"></i><span
                                class="pb-1 md:pb-0 text-sm atma">Inicio</span>
                        </a>
                    </li>
                    <li class="mr-6 my-2 md:my-0">
                        <a href="#"
                            class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-900 border-b-2 border-white hover:border-pink-500">
                            <i class="fas fa-tasks fa-fw mr-3"></i><span class="pb-1 md:pb-0 atma">Tareas</span>
                        </a>
                    </li>
                    <li class="mr-6 my-2 md:my-0">
                        <a href="#"
                            class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-900 border-b-2 border-white hover:border-purple-500">
                            <i class="fa fa-bell fa-fw mr-3"></i><span
                                class="pb-1 md:pb-0 text-sm atma">Notificaciones</span>
                        </a>
                    </li>
                    <li class="mr-6 my-2 md:my-0">
                        <a href="#"
                            class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-900 border-b-2 border-white hover:border-green-500">
                            <i class="fas fa-chart-area fa-fw mr-3"></i><span
                                class="pb-1 md:pb-0 text-sm atma">Analytics</span>
                        </a>
                    </li>
                    <li class="mr-6 my-2 md:my-0">
                        <a href="#"
                            class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-900 border-b-2 border-white hover:border-red-500">
                            <i class="fa fa-wallet fa-fw mr-3"></i><span class="pb-1 md:pb-0 text-sm atma">Pagos</span>
                        </a>
                    </li>
                </ul>


                <div class="relative pull-right pl-3 pr-5 md:pr-0">

                    <input type="search" placeholder="Search"
                        class=" bg-gray-100 text-sm mr-4 text-gray-800 transition border focus:outline-none focus:border-gray-700 rounded py-1 px-2 pl-10 appearance-none leading-normal">
                    <div class="absolute search-icon" style="top: 0.375rem;left: 1.75rem;">
                        <svg class="fill-current pointer-events-none text-gray-800 w-4 h-4"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path
                                d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z">
                            </path>
                        </svg>
                    </div>
                </div>

            </div>

        </div>
    </nav>
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
                    <i class="ni ni-key-25 text-info"></i> Asignación Cursos
                </a>
            </li>

        </ul>
    @endif

    @if (auth()->user()->hasRole('Estudiante'))
        <ul class="navbar-nav active">
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


    <br><br>







    @if (auth()->user()->avatar == '')
        <img id="avatar" src="{{ asset('./assets/img/user.png') }}" class="rounded-circle">
    @else
        <img id="avatar" src="{{ asset('storage/' . auth()->user()->avatar) }}" class="rounded-circle"
            height="200px" width="200px">
    @endif






    <form method="POST" class="" enctype="multipart/form-data" id="uploadForm">
        @csrf
        <div class="align-content-start">
            <input type="text" name="id" value="{{ auth()->user()->id }}" hidden readonly disabled>
            <label for="avatarInput" class="btn button"><i class="ni ni-image"></i></label>
            <input type="file" id="avatarInput" name="avatar" accept="image/*">
            <label for="submitInput" class="btn button">
                <i class="ni ni-cloud-upload-96"></i>
                <input id="submitInput" type="submit" onclick="resizeAndSubmit()" style="display: none;">
            </label>
        </div>
    </form>

    <canvas id="canvas" style="display: none;"></canvas>



@endsection

@section('contentPerfil')
    <div class="row">

    </div>
    <br>
    <br>
    <br>
    <div class="text-center">
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
    <div class="flex container w-full mx-auto pt-20">

        <div class="flex w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">

            <div class="m-10 max-w-sm">
                <div class="rounded-lg border bg-white px-4 pt-8 pb-10 shadow-lg">
                    <div class=" mx-auto w-36 rounded-full">
                        @if (auth()->user()->avatar == '')
                            <img id="avatar" class="mx-auto h-auto w-full aspect-square rounded-full" src="{{ asset('./assets/img/user.png') }}"
                                alt="">
                        @else
                            <img id="avatar" class="mx-auto h-auto w-full aspect-square rounded-full"
                                src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="">
                        @endif

                        <form method="POST" class="" enctype="multipart/form-data" id="uploadForm">
                            @csrf
                            <div class="align-content-start">
                                <input type="text" name="id" value="{{ auth()->user()->id }}" hidden readonly disabled>
                                <label for="avatarInput" class="btn button"><i class="fa fa-image"></i></label>
                                <input type="file" id="avatarInput" name="avatar" accept="image/*">
                                <label for="submitInput" class="btn button">
                                    <i class="fa fa-upload"></i>
                                    <input id="submitInput" type="submit" onclick="resizeAndSubmit()" style="display: none;">
                                </label>
                            </div>
                        </form>

                        <canvas id="canvas" style="display: none;"></canvas>


                    </div>
                    <h1 class="my-1 text-center text-xl font-bold leading-8 text-gray-900">{{ auth()->user()->name }}
                        {{ auth()->user()->lastname1 }} {{ auth()->user()->lastname2 }}</h1>
                    <h3 class="font-lg text-semibold text-center leading-6 text-gray-600">
                        {{ auth()->user()->roles->pluck('name')[0] }}

                    </h3>
                    <p class="text-center text-sm leading-6 text-gray-500 hover:text-gray-600">
                        ____________________________________________________________</p>
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
                            <span>Se unío el</span>
                            <span class="ml-auto">{{ auth()->user()->created_at }}</span>

                        </li>
                    </ul>
                </div>




            </div>
            <div class="m-10 max-w-sm">
                <div class="rounded-lg border bg-white px-4 pt-8 pb-10 shadow-lg">
                    <h1 class="my-1 text-center text-xl font-bold leading-8 text-gray-900">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mas Información&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h1>
                    <p class="text-center text-sm leading-6 text-gray-500 hover:text-gray-600">
                        ____________________________________________________</p>
                    <ul
                        class="mt-3 divide-y rounded bg-gray-100 py-2 px-3 text-gray-600 shadow-sm hover:text-gray-700 hover:shadow">

                        <li class="flex items-center py-3 text-sm">
                            <span>País origen</span>
                            <span class="ml-auto"> {{ auth()->user()->PaisReside }}</span>
                        </li>
                        <li class="flex items-center py-3 text-sm">
                            <span>Ciudad origen</span>
                            <span class="ml-auto">{{ auth()->user()->CiudadReside }}</span>

                        </li>
                        <li class="flex items-center py-3 text-sm">
                            <span>Correo Electrónico: </span>
                            &nbsp;
                            <span class="ml-auto"> {{ auth()->user()->email }}</span>

                        </li>
                        @if (auth()->user()->hasRole('Docente'))
                            @forelse ($atributosD as $atributosD)
                                <li class="flex items-center py-3 text-sm">
                                    <span>Profesion: </span>
                                    &nbsp;
                                    <span class="ml-auto"> {{ $atributosD->formacion }}</span>

                                </li>
                                <li class="flex items-center py-3 text-sm">
                                    <span>Especializacion: </span>
                                    &nbsp;
                                    <span class="ml-auto"> {{ $atributosD->Especializacion }}</span>

                                </li>
                                <li class="flex items-center py-3 text-sm">
                                    <span>Experiencia Laboral: </span>
                                    &nbsp;
                                    <span class="ml-auto"> {{ $atributosD->ExperienciaL }}</span>

                                </li>


                            @empty
                            @endforelse

                            <li class="flex items-center py-3 text-sm">
                                <span>Hoja de vida: </span>
                                &nbsp;
                                @if (auth()->user()->cv_file == '')
                                    <h3>Aún no se ha subido una hoja de vida</h3>
                                @else
                                    <a href="{{ asset('storage/' . auth()->user()->cv_file) }}"> Ver hoja de vida </a>
                                @endif
                            </li>
                        @endif
                    </ul>

                </div>


            </div>
            <div class="m-10  max-w-sm">
                <div class="rounded-lg border bg-white px-8 pt-10 pb-12 shadow-lg">

                    @if (auth()->user()->hasRole('Docente'))
                        <h1 class="my-1 text-center text-xl font-bold leading-8 text-gray-900">Tus últimas 4 experiencias
                            laborales</h1>
                        <table>
                            <tr>
                                <th>Lugar de Trabajo</th>
                                <th>Cargo</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Contacto de Referencia</th>
                            </tr>
                            @forelse ($trabajos as $trabajos)
                                <tr>
                                    <td>{{ $trabajos->empresa }}</td>
                                    <td>{{ $trabajos->cargo }}</td>
                                    <td>{{ $trabajos->fecha_inicio }}</td>
                                    <td>{{ $trabajos->fecha_fin }}</td>
                                    <td>{{ $trabajos->contacto_ref }}</td>
                                </tr>
                            @empty

                                <tr class="">
                                    <td></td>
                                    <td></td>
                                    <td >

                                        <h1 class="">No se han registrado tus trabajos más recientes</h1>
                                    </td>
                                    <td></td>
                                    <td></td>

                                </tr>
                            @endforelse


                        </table>
                    @endif


                </div>
            </div>
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
    @include('FundacionPlantillaUsu.layout')
@endif
