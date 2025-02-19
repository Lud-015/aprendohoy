
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verifica tu dirección de correo electrónico') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Se ha enviado un nuevo enlace de verificación a tu dirección de correo electrónico.') }}
                        </div>
                    @endif

                    <p>
                        {{ __('Antes de continuar, por favor verifica tu correo electrónico con el enlace que te enviamos.') }}
                    </p>
                    <p>
                        {{ __('Si no recibiste el correo electrónico') }},
                        <form method="POST" action="{{ route('verification.resend') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                                {{ __('haz clic aquí para solicitar otro') }}
                            </button>.
                        </form>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include('layoutlogin')
