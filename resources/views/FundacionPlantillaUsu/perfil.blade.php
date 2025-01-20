@include('FundacionPlantillaUsu.header')
@include('FundacionPlantillaUsu.navbar')


<h1>Perfil del Usuario</>
    <!-- Contenedor de la foto de perfil redondeada -->
    @if (auth()->user()->avatar == '')
        <div class="profile-picture-container">
            <img src="{{ asset('./resources/img/usuario.jpg') }}" alt="Foto de Perfil">
        </div>
    @else
        <div class="profile-picture-container">
            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="rounded-circle" height="200px"
                width="200px">
        </div>
    @endif

    <form action="actualizar_perfil.php" method="POST" enctype="multipart/form-data" class="profile-form">

        <div class="section-container">
            <label for="nombre">Nombre:</label>
            <label for="nombre">{{ auth()->user()->name }} {{ auth()->user()->lastname1 }}
                {{ auth()->user()->lastname2 }}</label>
        </div>

        <div class="section-container">
            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <label for="fecha_nacimiento">{{ auth()->user()->fechadenac }}</label>
        </div>

        <div class="section-container">
            <label for="correo">Correo Electrónico:</label>
            <label for="correo">{{ auth()->user()->email }}</label>
        </div>

        <div class="section-container">
            <label for="celular">Celular:</label>
            <label for="celular">{{ auth()->user()->Celular }}</label>

        </div>


        <i class="ni location_pin mr-2"></i>{{ auth()->user()->CiudadReside }},
        {{ auth()->user()->PaisReside }}



        @if (auth()->user()->hasRole('Docente'))

            @forelse ($atributosD as $atributosD)
                <br>
                <label for="celular">Profesion: </label>{{ $atributosD->formacion }}
                <br>
                <label for="celular">Especializacion: </label>{{ $atributosD->Especializacion }}
                <br>
                <label for="celular">Experiencia Laboral:</label> {{ $atributosD->ExperienciaL }}
            @empty
            @endforelse

            <div class="section-container">
                <p>Tus últimas 4 experiencias laborales:</p>
                <table>
                    <tr>
                        <th>Lugar de Trabajo</th>
                        <th>Cargo</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Contacto de Referencia</th>
                    </tr>
                    @forelse ($trabajos as $trabajos )
                        <tr>
                            <td>{{$trabajos->empresa}}</td>
                            <td>{{$trabajos->cargo}}</td>
                            <td>{{$trabajos->fecha_inicio}}</td>
                            <td>{{$trabajos->fecha_fin}}</td>
                            <td>{{$trabajos->contacto_ref}}</td>
                        </tr>
                    @empty
                        <br>
                        <span>No se han registrado sus trabajos más recientes</span>
                    @endforelse


                </table>
            </div>



            <div class="section-container">


                <div class="form-group">
                    <label class="form-control-label" for="input-address">Hoja de vida</label>
                </div>
                @if (auth()->user()->cv_file == '')
                    <h3>Aún no se ha subido una hoja de vida</h3>
                @else
                    <a href="{{ asset('storage/' . auth()->user()->cv_file) }}"> Ver hoja de vida </a>
                @endif


            </div>


        @endif

        <div class="section-container">
            <a class="button-generic" href="{{ route('EditarperfilIndex', [auth()->user()->id]) }}">Editar Perfil</a>
            <a class="button-generic" href="{{ route('CambiarContrasena', [auth()->user()->id]) }}">Editar Contraseña</a>
        </div>
    </form>

    @include('FundacionPlantillaUsu.footer')
    </body>

    </html>
