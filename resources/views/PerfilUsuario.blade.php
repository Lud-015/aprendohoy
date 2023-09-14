@section('titulo')

Perfil {{$usuario->name}} {{$usuario->lastname1}} {{$usuario->lastname2}}

@endsection

@section('nav')
    @if (auth()->user()->hasRole('Administrador'))
    <a href="/EditarUsuario/{{$usuario->id}}" class="btn btn-sm btn-primary">Editar</a>
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




@section('contentPerfil')

<div class="row">
    <div class="col">
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
    </div>
  </div>
  <div class="text-center">
    <h3>
        {{$usuario->name}} {{$usuario->lastname1}} {{$usuario->lastname2}}
        <span class="font-weight-light"></span>
    </h3>


    <div class="h5 font-weight-300">
      {{$usuario->roles->pluck('name')}}
    </div>

    @if (auth()->user()->roles = "Administrador" or auth()->user()->roles = "Docente")
    @foreach ($atributosD as $atributosD)
    <div class="h5 mt-4">
      <i class="ni business_briefcase-24 mr-2"></i>{{$atributosD->Especializacion}}
      <br>
      <i class="ni business_briefcase-24 mr-2"></i>{{$atributosD->formacion}}
      <br>
      <i class="ni business_briefcase-24 mr-2"></i>{{$atributosD->ExperienciaL}}
    </div>

    @endforeach

    @endif

    <div>
        <i class="ni education_hat mr-2"></i>

        <i class="ni location_pin mr-2"></i>{{$usuario->CiudadReside}}, {{$usuario->PaisReside}}


      </div>
  </div>



@endsection

@section('content')

<div class="card bg-secondary shadow">
    <div class="card-header bg-white border-0">
      <div class="row align-items-center">
        <div class="col-8">
          <h3 class="mb-0">Perfil de {{$usuario->name}}</h3>

        </div>




      </div>
    </div>
    <div class="card-body">
      <form>
        <h6 class="heading-small text-muted mb-4">Informacion de usuario</h6>
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
        <h6 class="heading-small text-muted mb-4">Informacion de Contacto</h6>
        <div class="pl-lg-4">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
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
  </div>


  @endsection

@include('PerfilUsuarioLayout')
