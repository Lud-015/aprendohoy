@section('titulo')

Perfil {{$usuario->name}} {{$usuario->lastname1}} {{$usuario->lastname2}}

@endsection

@section('nav')
    @if (auth()->user()->hasRole('Administrador'))
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link " href="{{ route('Miperfil') }}">
                    <i class="ni ni-circle-08 text-green"></i> Mi perfil
                </a>
            </li>
            <li class="nav-item ">
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


@section('avatar')
    @if ($usuario->avatar == '')


    <img src="{{asset('./assets/img/user.png')}}" class="rounded-circle">

    @else
    <img src="{{asset('storage/'. $usuario->avatar)}}" class="rounded-circle"  height="200px" width="200px">
        @endif
@endsection


@section('contentPerfil')

<br><br>
<div class="row">
    {{-- <div class="col">
      <div class="card-profile-stats d-flex justify-content-center mt-md-5">
        <div>
          <span class="heading">0</span>
          <span class="description">Amigos</span>
        </div>
        <div>
          <span class="heading">0</span>
          <span class="description">Fotos</span>
        </div>
        <div>
          <span class="heading">0</span>
          <span class="description">Foros</span>
        </div>
      </div>
    </div> --}}
  </div>
  <div class="text-center">
    <h3>
        {{$usuario->name}} {{$usuario->lastname1}} {{$usuario->lastname2}}
        <span class="font-weight-light"></span>
    </h3>


    <div class="h5 font-weight-300">
      {{$usuario->roles->pluck('name')[0]}}
    </div>

    @if ($usuario->hasRole('Docente'))

    {{-- @forelse ($atributosD as $atributosD)
    Profesion
    <br>
    {{$atributosD->formacion}}
    <br>
    Especializacion
    <br>
    {{$atributosD->Especializacion}}
    <br>
    Experiencia Laboral
    <br>
    {{$atributosD->ExperienciaL}}
    @empty

    @endforelse --}}


    @endif

    <br><br>
    <div>
        <i class="ni education_hat mr-2"></i>

        <i class="ni location_pin mr-2"></i>{{$usuario->CiudadReside}}, {{$usuario->PaisReside}}


      </div>
  </div>



@endsection

@section('content')


<br>
<div class="card bg-secondary shadow">
    <div class="card-header bg-white border-0">
      <div class="row align-items-center">
        <div class="col-8">

        <h3 class="mb-0">Perfíl de {{$usuario->name}}</h3>
        <br>
        <a href="javascript:history.back()" class="btn btn-sm btn-primary">
            &#9668; Volver
        </a>

        @if (auth()->user()->hasRole('Administrador'))
        <a href="{{route('EditarperfilUser', [$usuario->id])}}" class="btn btn-sm btn-warning">Editar</a>
        <button type="button" class="btn btn-sm btn-darker" data-toggle="modal" data-target="#exampleModal">Ver Credenciales</button>
        @endif
        </div>


         <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ver Credenciales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="adminPasswordForm">
                <div class="modal-body">
                  <div class="form-group">
                    <label for="adminPassword">Contraseña de Administrador:</label>
                    <input type="password" class="form-control" id="adminPassword" required>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                  <button type="submit" class="btn btn-primary">Verificar</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ver Credenciales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                Correo Electrónico: {{$usuario->email}}
                <br>
                @if ($usuario->tutor)
                Contraseña Temporal: {{substr($usuario->tutor->nombreTutor,0,1).substr($usuario->tutor->appaternoTutor,0,1).substr($usuario->tutor->apmaternoTutor,0,1).$usuario->tutor->CI}}
                @else
                Contraseña Temporal: {{substr($usuario->name,0,1).substr($usuario->lastname1,0,1).substr($usuario->lastname2,0,1).$usuario->CI}}
                @endif
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Compartir</button>
              </div>
            </div>
          </div>
        </div>

          <script>
            // Escuchar el envío del formulario
            document.getElementById("adminPasswordForm").addEventListener("submit", function(event) {
              event.preventDefault(); // Evitar que se envíe el formulario

              // Verificar la contraseña de administrador
              var adminPassword = document.getElementById("adminPassword").value;

              // Aquí deberías tener tu lógica para verificar la contraseña con la base de datos o alguna lógica de autenticación

              // Ejemplo de lógica de autenticación: Si la contraseña es "admin123", entonces abrir el modal
              if (adminPassword === "admin123") {
                $('#exampleModal1').modal('show'); // Abre el modal
              } else {
                alert("Contraseña incorrecta"); // Muestra un mensaje de error si la contraseña es incorrecta
              }
            });
          </script>


      </div>
    </div>
    <div class="card-body">
      <form>
        <h6 class="heading-small text-muted mb-4">Información de usuario</h6>
        <div class="pl-lg-4">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label" for="input-username">Nombre</label>
                <input type="text" disabled id="input-username" class="form-control form-control-alternative" placeholder="Username" value="{{$usuario->name}}">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label" for="input-email">Correo Electronico</label>
                <input type="email" disabled id="input-email" class="form-control form-control-alternative" placeholder="{{$usuario->email}}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label" for="input-first-name">Apellido Paterno
                </label>
                <input type="text"  disabled id="input-first-name" class="form-control form-control-alternative" placeholder="First name" value="{{$usuario->lastname1}}">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label" for="input-last-name">Apellido Materno</label>
                <input type="text"  disabled id="input-last-name" class="form-control form-control-alternative" placeholder="Last name" value="{{$usuario->lastname2}}">
              </div>
            </div>
          </div>
        </div>
        <hr class="my-4" />
        <!-- Address -->
        <h6 class="heading-small text-muted mb-4">Información de Contacto</h6>
        <div class="pl-lg-4">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                @if ($usuario->tutor)
                        <div class="pl-lg-4">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label" for="input-username">Nombre</label>
                <input type="text" disabled id="input-username" class="form-control form-control-alternative" placeholder="Username" value="{{$usuario->tutor->nombreTutor}}">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label" for="input-email">Correo Electrónico</label>
                <input type="email" disabled id="input-email" class="form-control form-control-alternative" placeholder="{{$usuario->email}}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label" for="input-first-name">Apellido Paterno
                </label>
                <input type="text"  disabled id="input-first-name" class="form-control form-control-alternative" placeholder="First name" value="{{$usuario->tutor->appaternoTutor}}">
              </div>
              <div class="form-group">
                <label class="form-control-label" for="input-first-name">Dirección
                </label>
                <input type="text"  disabled id="input-first-name" class="form-control form-control-alternative" placeholder="Sin Direccion" value="{{$usuario->tutor->Direccion}}">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label" for="input-last-name">Apellido Materno</label>
                <input type="text"  disabled id="input-last-name" class="form-control form-control-alternative" placeholder="Last name" value="{{$usuario->tutor->apmaternoTutor}}">
              </div>
              <div class="form-group">
                <label class="form-control-label" for="input-last-name">CI</label>
                <input type="text"  disabled id="input-last-name" class="form-control form-control-alternative" placeholder="Last name" value="{{$usuario->tutor->CI}}">
              </div>

            </div>

          </div>
        </div>

                @else

                @endif
                <label class="form-control-label" for="input-address">Celular</label>
                <input id="input-address" class="form-control form-control-alternative" disabled placeholder="Home Address" value="{{$usuario->Celular}}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4">
              {{-- <div class="form-group">
                <label class="form-control-label" for="input-city">Ciudad</label>
                <input type="text" id="input-city" class="form-control form-control-alternative" placeholder="City" value="New York">
              </div> --}}
            </div>
            @if ($usuario->hasRole('Docente'))

            <div class="form-group">
              <label class="form-control-label" for="input-address">Hoja de vida</label>
            </div>
              @if ($usuario->cv_file == '')
                  <h3>Aún no se ha subido una hoja de vida</h3>
              @else

              <a href="{{asset('storage/'. auth()->user()->cv_file)}}"> Ver hoja de vida </a>

             @endif
            <br>



            @endif




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

    @if ($usuario->hasRole('Docente'))
    <div class="border p-3">

      <div class="table-responsive card">
         <p>Últimas 4 experiencias laborales de {{$usuario->name }} :</p>
         <table class="table align-items-center">
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
             <tr>
                 <td>NO SE REGISTRARON TUS ULTIMOS TRABAJOS</td>
             </tr>
             @endforelse


         </table>
     </div>
     @endif
    </div>

  </div>
  @if(session('success'))
  <div class="alert alert-success">
      {{ session('success') }}
  </div>
  @endif

  @endsection



  @include('PerfilUsuarioLayout')




