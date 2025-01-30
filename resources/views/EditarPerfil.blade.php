@section('titulo')
    Editar Perfil
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
            <li class="nav-item">
                <a class="nav-link " href="./examples/tables.html">
                    <i class="ni ni-bullet-list-67 text-red"></i> Mis Aportes
                </a>
            </li>


        </ul>
    @endif
@endsection


@section('content')
    <div class="p-4 pl-4">
        <a href="javascript:history.back()" class="btn btn-primary">
            &#9668; Volver
        </a>
        <br>

        <form action="{{ route('EditarperfilPost', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <br>

            <h1>Datos De Contacto</h1>

            <div class="form-group mb-4">
                <label for="Celular">Número de Celular</label>
                <input type="text" name="Celular" value="{{ auth()->user()->Celular }}" class="form-control">
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="PaisReside">Pais:</label>
                    <input type="text" name="PaisReside" value="{{ auth()->user()->PaisReside }}" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="CiudadReside">Ciudad:</label>
                    <input type="text" name="CiudadReside" value="{{ auth()->user()->CiudadReside }}" class="form-control">
                </div>
            </div>

            <br>

            @if (auth()->user()->hasRole('Docente'))
                @foreach ($atributosD as $atributo)
                    <label for="">Datos Profesionales</label>
                    <br>

                    <div class="form-row mb-4">
                        <div class="form-group col-md-4">
                            <label for="formacion">Formación Académica:</label>
                            <input type="text" name="formacion" placeholder="Formación Académica" value="{{ $atributo->formacion }}" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="Especializacion">Experiencia Laboral:</label>
                            <input type="text" name="Especializacion" placeholder="Experiencia Laboral" value="{{ $atributo->Especializacion }}" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="ExperienciaL">Especialización:</label>
                            <input type="text" name="ExperienciaL" placeholder="Especialización" value="{{ $atributo->ExperienciaL }}" class="form-control">
                        </div>
                    </div>
                @endforeach

                <br>

                <h2>Últimos Trabajos Realizados</h2>

                <table class="table table-responsive-sm table-hover">
                    <thead>
                        <tr>
                            <th>Empresa</th>
                            <th>Cargo</th>
                            <th>Año Ingreso</th>
                            <th>Año Salida</th>
                            <th>Contacto Referencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ultimosTrabajos as $trabajo)
                            <tr>
                                <td><input type="text" name="trabajos[{{ $loop->index }}][empresa]" value="{{ $trabajo->empresa }}" class="form-control"></td>
                                <td><input type="text" name="trabajos[{{ $loop->index }}][cargo]" value="{{ $trabajo->cargo }}" class="form-control"></td>
                                <td><input type="date" name="trabajos[{{ $loop->index }}][fechain]" value="{{ $trabajo->fecha_inicio }}" class="form-control"></td>
                                <td><input type="date" name="trabajos[{{ $loop->index }}][fechasal]" value="{{ $trabajo->fecha_fin }}" class="form-control"></td>
                                <td><input type="text" name="trabajos[{{ $loop->index }}][contacto]" value="{{ $trabajo->contacto_ref }}" class="form-control"></td>
                            </tr>
                        @empty
                            @for ($i = 0; $i < 4; $i++)
                                <tr>
                                    <td><input type="text" name="trabajos[{{ $i }}][empresa]" value="" class="form-control"></td>
                                    <td><input type="text" name="trabajos[{{ $i }}][cargo]" value="" class="form-control"></td>
                                    <td><input type="date" name="trabajos[{{ $i }}][fechain]" value="" class="form-control"></td>
                                    <td><input type="date" name="trabajos[{{ $i }}][fechasal]" value="" class="form-control"></td>
                                    <td><input type="text" name="trabajos[{{ $i }}][contacto]" value="" class="form-control"></td>
                                </tr>
                            @endfor
                        @endforelse
                    </tbody>
                </table>
            @endif

            <div class="form-group mt-4 mb-4">
                <label for="confirmpassword">INGRESA LA CONTRASEÑA PARA HACER LOS CAMBIOS</label>
                <div class="input-group">
                    <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Contraseña" class="form-control ml-4">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i id="togglePassword" class="fa fa-eye-slash" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="form-group m-4">
                <input class="btn btn-success" type="submit" value="Guardar Cambios">
            </div>
        </form>
    </div>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <h2 class="bg-danger alert-danger">{{ $error }}</h2>
        @endforeach
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#confirmpassword');

        togglePassword.addEventListener('click', function() {
            // Cambiar el tipo de input entre 'password' y 'text'
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // Cambiar el ícono del ojo entre abierto y cerrado
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
@endsection

@include('layout')
