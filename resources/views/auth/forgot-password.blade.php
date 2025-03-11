@section('titulo')
Restear Contraseña
@endsection



@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card bg-gray-transparent shadow border-0">
                <div class="card-header text-white text-center fw-bold">{{ __('Resetear Contraseña') }}</div>

                <div class="card-body py-4">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <!-- Campo de correo electrónico -->
                        <div class="mb-3">
                            <label for="email" class="form-label text-white">{{ __('Correo Electrónico') }}</label>
                            <div class="input-group">
                                <span class="input-group-text rounded-start-pill"><i class="fa fa-envelope"></i></span>
                                <input id="email" type="email" class="form-control rounded-end-pill @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Botón de envío -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary rounded-pill">
                                {{ __('Enviar Link de Restablecimiento') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include('layoutlogin')
