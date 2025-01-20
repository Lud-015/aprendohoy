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
    <div class=" p-4 pl-4">
        <a href="javascript:history.back()" class="btn btn-primary">
            &#9668; Volver
        </a>
        <br>


        <form class="" action="{{ route('EditarperfilPost', auth()->user()->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <br>

            <h1>Datos De Contacto</h1>

            <div style="display: flex; align-items: center;" class="mb-4">
                <label for="">Número de Celular</label>

                <input type="text" value="{{ auth()->user()->Celular }}" name="Celular">
            </div>

            <div style="display: flex; align-items: center;">
                <div>

                    <label for="">Pais:</label>
                    <input type="text" value="{{ auth()->user()->PaisReside }}" name="PaisReside">
                </div>
                <div class="ml-4">

                    <label class="ml-5" for="">Ciudad:</label>
                    <input type="text" value="{{ auth()->user()->CiudadReside }}" name="CiudadReside">
                </div>

            </div>
            <br>
            @if (auth()->user()->hasRole('Docente'))
                @foreach ($atributosD as $atributosD)
                    <label for="">Datos del Profesionales</label>
                    <br>

                    <div style="display: flex; align-items: center; " class="mb-4">
                        <div>

                            <span>
                                Formación Academica:
                            </span>
                            <br>
                            <input type="text" placeholder="Formacion Academica" name="formacion"
                                value="{{ $atributosD->formacion }}">

                        </div>
                        <div class="ml-4">

                            <span>
                                Experiencia Laboral:
                            </span>
                            <br>
                            <input type="text" placeholder="Experiencia Laboral" name="Especializacion"
                                value="{{ $atributosD->Especializacion }}">
                        </div>
                        <div class="ml-4">

                            <span>

                                Especialización:
                            </span>
                            <br>
                            <input type="text" placeholder="Especilaizacion" name="ExperienciaL"
                                value="{{ $atributosD->ExperienciaL }}">
                            <br>
                        </div>
                    </div>
                @endforeach

                <br>

                <h2>Ultimos Trabajos Realizados</h2>

                <table class="table table-responsive-sm table-hover">
                    <tr>
                        <th>Empresa</th>
                        <th>Cargo</th>
                        <th>Año Ingreso</th>
                        <th>Año Salida</th>
                        <th>Contacto Referencia</th>
                    </tr>
                    @forelse ($ultimosTrabajos as $ultimosTrabajos)
                        <tr>
                            <input type="text" name="trabajos[{{ $loop->index }}][id]"
                                value="{{ $ultimosTrabajos->id }}" hidden>
                            <td><input type="text" name="trabajos[{{ $loop->index }}][empresa]"
                                    value="{{ $ultimosTrabajos->empresa }}"></td>
                            <td><input type="text" name="trabajos[{{ $loop->index }}][cargo]"
                                    value="{{ $ultimosTrabajos->cargo }}"></td>
                            <td><input type="date" name="trabajos[{{ $loop->index }}][fechain]"
                                    value="{{ $ultimosTrabajos->fecha_inicio }}"></td>
                            <td><input type="date" name="trabajos[{{ $loop->index }}][fechasal]"
                                    value="{{ $ultimosTrabajos->fecha_fin }}"></td>
                            <td><input type="text" name="trabajos[{{ $loop->index }}][contacto]"
                                    value="{{ $ultimosTrabajos->contacto_ref }}"></td>
                        </tr>

                    @empty
                        <tr>
                            <input type="text" name="trabajos[0][id]" value="" hidden>
                            <td><input type="text" name="trabajos[0][empresa]" value=""></td>
                            <td><input type="text" name="trabajos[0][cargo]" value=""></td>
                            <td><input type="date" name="trabajos[0][fechain]" value=""></td>
                            <td><input type="date" name="trabajos[0][fechasal]" value=""></td>
                            <td><input type="text" name="trabajos[0][contacto]" value=""></td>
                        </tr>
                        <tr>
                            <input type="text" name="trabajos[1][id]" value="" hidden>
                            <td><input type="text" name="trabajos[1][empresa]" value=""></td>
                            <td><input type="text" name="trabajos[1][cargo]" value=""></td>
                            <td><input type="date" name="trabajos[1][fechain]" value=""></td>
                            <td><input type="date" name="trabajos[1][fechasal]" value=""></td>
                            <td><input type="text" name="trabajos[1][contacto]" value=""></td>
                        </tr>
                        <tr>
                            <input type="text" name="trabajos[2][id]" value="" hidden>
                            <td><input type="text" name="trabajos[2][empresa]" value=""></td>
                            <td><input type="text" name="trabajos[2][cargo]" value=""></td>
                            <td><input type="date" name="trabajos[2][fechain]" value=""></td>
                            <td><input type="date" name="trabajos[2][fechasal]" value=""></td>
                            <td><input type="text" name="trabajos[2][contacto]" value=""></td>
                        </tr>
                        <tr>
                            <input type="text" name="trabajos[3][id]" value="" hidden>
                            <td><input type="text" name="trabajos[3][empresa]" value=""></td>
                            <td><input type="text" name="trabajos[3][cargo]" value=""></td>
                            <td><input type="date" name="trabajos[3][fechain]" value=""></td>
                            <td><input type="date" name="trabajos[3][fechasal]" value=""></td>
                            <td><input type="text" name="trabajos[3][contacto]" value=""></td>
                        </tr>
                    @endforelse

                </table>
            @endif


            {{-- @if (auth()->user()->hasRole('Docente') or auth()->user()->hasRole('Administrador'))

      @foreach ($atributosD as $atributosD)

      <input type="text" placeholder="Formacion Academica" name="formacion" value="{{ $atributosD->formacion }}">
      <br>
      <input type="text" placeholder="Experiencia Laboral" name="Especializacion"  value="{{ $atributosD->Especializacion }}">
      <br>
      <input type="text"  placeholder="Especilaizacion" name="ExperienciaL" value="{{ $atributosD->ExperienciaL }}">
      <br>

      @endforeach
      @endif
 --}}



            <br>






            <div style="display: flex; align-items: center" class="ml-4 mt-4 mb-4">
                <span>INGRESA LA CONTRASEÑA PARA HACER LOS CAMBIOS</span>

                <div class="input-group">
                    <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Contraseña" class="ml-4 ">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i id="togglePassword" class="fa fa-eye-slash" aria-hidden="true"></i>
                        </span>
                    </div>
                    <br>
                </div>
            </div>
            <div class="m-4">

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

        togglePassword.addEventListener('click', function(e) {
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
