
@section('content')
<div class="container pt-lg-6">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card bg-translucent-light shadow border-0">
                <div class="card-body px-lg-2 py-lg-2">
                    @if (auth()->check())
                    <div class="text-center text-muted mb-4">
                        <h5 class="text-white">Ya Iniciaste Sesión</h5>
                        <a class="btn btn-facebook" href="{{ route('Inicio') }}">
                            Volver al inicio
                        </a>
                    </div>
                    @else
                    <div class="text-center text-muted mb-4">
                        <h5 class="text-white">Iniciar Sesión</h5>
                    </div>
                    <form role="form" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                </div>
                                <input class="form-control" placeholder="Correo Electronico"
                                    type="email" name="email">
                            </div>
                        </div>
                        <div class="form-group focused">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i
                                            class="ni ni-lock-circle-open"></i></span>
                                </div>
                                <input class="form-control" placeholder="Contraseña" type="password"
                                    name="password">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="button"
                                        onclick="togglePasswordVisibility(this)">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-facebook my-4 ">Acceder</button>
                        </div>
                    </form>

                    <a class="text-white" href="{{route('signin')}}">Crear una nueva cuenta</a>
                    <br>
                    <a class="text-white" href="{{route('password.request')}}">¿Olvidaste tu Contraseña?</a>
                    @endif

                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@include('layoutlogin')
