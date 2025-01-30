
@section('content')
<div class="container">
    <h1 class="mb-4">Cuestionario: {{ $cuestionario->titulo_cuestionario }}</h1>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($intentosPrevios >= 2)
        <div class="alert alert-info">
            <p>Has alcanzado el máximo número de intentos permitidos.</p>
            <p>Tu nota final: <strong>{{ session('nota_final', 'No disponible') }}</strong></p>
        </div>
    @else
        <p>Intentos realizados: {{ $intentosPrevios }} de 2</p>
        <form action="{{ route('cuestionario.responder', $cuestionario->id ) }}" method="POST">
            @csrf
            <input type="hidden" name="inscrito_id" value="{{ $inscripcion->id }}">
            @foreach ($cuestionario->preguntas as $pregunta)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Pregunta {{ $loop->iteration }}: {{ $pregunta->pregunta }}</h5>
                        <p class="card-text">Puntos: {{ $pregunta->puntos }}</p>

                        @if ($pregunta->tipo === 'multiple')
                            <!-- Pregunta de opción múltiple -->
                            @foreach ($pregunta->opciones as $opcion)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="respuestas[{{ $pregunta->id }}]" id="opcion{{ $opcion->id }}" value="{{ $opcion->id }}">
                                    <label class="form-check-label" for="opcion{{ $opcion->id }}">
                                        {{ $opcion->texto }}
                                    </label>
                                </div>
                            @endforeach
                        @elseif ($pregunta->tipo === 'verdadero_falso')
                            <!-- Pregunta de verdadero/falso -->
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="respuestas[{{ $pregunta->id }}]" id="verdadero{{ $pregunta->id }}" value="1">
                                <label class="form-check-label" for="verdadero{{ $pregunta->id }}">
                                    Verdadero
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="respuestas[{{ $pregunta->id }}]" id="falso{{ $pregunta->id }}" value="0">
                                <label class="form-check-label" for="falso{{ $pregunta->id }}">
                                    Falso
                                </label>
                            </div>
                        @else
                            <!-- Pregunta abierta -->
                            <div class="form-group">
                                <textarea class="form-control" name="respuestas[{{ $pregunta->id }}]" rows="3" placeholder="Escribe tu respuesta aquí..."></textarea>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary">Enviar respuestas</button>
        </form>
    @endif
</div>

@endsection


@include('layout')
