@section('content')
<!-- Temporizador -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5>
        <i class="bi bi-clock-history me-2"></i>
        <span id="tiempoRestante">
            @if ($cuestionario->tiempo_limite)
                Tiempo restante: {{ $cuestionario->tiempo_limite }}:00
            @else
                ⏳ Tiempo ilimitado
            @endif
        </span>
    </h5>
</div>

<div class="container py-5">
    <!-- Barra de progreso visual tipo Kahoot -->
    <div class="progress mb-5 rounded-pill" style="height: 25px;">
        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" id="progressBar"></div>
    </div>

    <form method="POST" action="{{ route('responderCuestionario', $cuestionario->id) }}">
        @csrf
        @foreach ($cuestionario->preguntas->shuffle() as $pregunta)
        <div class="card shadow-lg pregunta" id="pregunta-{{ $loop->index }}" style="{{ $loop->index > 0 ? 'display: none;' : '' }}">
            <div class="card-body">
                <div class="mb-4">
                    <span class="badge bg-primary fs-6">Pregunta {{ $loop->iteration }} de {{ $cuestionario->preguntas->count() }}</span>
                    <h4 class="mt-3">{{ $pregunta->pregunta }}</h4>
                    <p class="text-muted">Puntos: {{ $pregunta->puntaje }}</p>
                </div>

                @if ($pregunta->tipo === 'opcion_multiple')
                    @foreach ($pregunta->respuestas as $respuesta)
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="respuestas[{{ $pregunta->id }}]" id="respuesta{{ $respuesta->id }}" value="{{ $respuesta->id }}">
                        <label class="form-check-label" for="respuesta{{ $respuesta->id }}">
                            {{ $respuesta->contenido }}
                        </label>
                    </div>
                    @endforeach
                @elseif ($pregunta->tipo === 'boolean')
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="respuestas[{{ $pregunta->id }}]" id="verdadero{{ $pregunta->id }}" value="1">
                        <label class="form-check-label" for="verdadero{{ $pregunta->id }}">
                            Verdadero
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="respuestas[{{ $pregunta->id }}]" id="falso{{ $pregunta->id }}" value="0">
                        <label class="form-check-label" for="falso{{ $pregunta->id }}">
                            Falso
                        </label>
                    </div>
                @else
                    <div class="form-group">
                        <textarea class="form-control" name="respuestas[{{ $pregunta->id }}]" rows="3" placeholder="Escribe tu respuesta aquí..."></textarea>
                    </div>
                @endif

                <div class="d-flex justify-content-between mt-4">
                    @if (!$loop->first)
                        <button type="button" class="btn btn-outline-secondary btn-lg btn-anterior">
                            ← Anterior
                        </button>
                    @else
                        <span></span>
                    @endif

                    @if (!$loop->last)
                        <button type="button" class="btn btn-primary btn-lg btn-siguiente">
                            Siguiente →
                        </button>
                    @else
                        <button type="submit" class="btn btn-success btn-lg" id="btnSubmit">
                            ✅ Enviar Respuestas
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </form>
</div>

<!-- Script mejorado -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    let formSubmitted = false;

    const form = document.querySelector('form');
    const preguntas = document.querySelectorAll('.pregunta');
    const progressBar = document.getElementById('progressBar');
    const btnSubmit = document.getElementById('btnSubmit');
    let preguntaActual = 0;

    // Enviar - protección doble
    form.addEventListener('submit', function() {
        formSubmitted = true;
        if (btnSubmit) {
            btnSubmit.disabled = true;
            btnSubmit.innerText = 'Enviando...';
        }
    });

    // Advertencia si intenta abandonar
    window.addEventListener('beforeunload', function(e) {
        if (!formSubmitted) {
            e.preventDefault();
            e.returnValue = '';
            return '';
        }
    });

    function actualizarProgreso() {
        const progreso = ((preguntaActual + 1) / preguntas.length) * 100;
        progressBar.style.width = `${progreso}%`;
    }

    function mostrarPregunta(index) {
        preguntas.forEach((pregunta, i) => {
            pregunta.style.display = i === index ? 'block' : 'none';
        });
        actualizarProgreso();
    }

    preguntas.forEach((pregunta, index) => {
        const btnSiguiente = pregunta.querySelector('.btn-siguiente');
        const btnAnterior = pregunta.querySelector('.btn-anterior');

        if (btnSiguiente) {
            btnSiguiente.addEventListener('click', () => {
                if (preguntaActual < preguntas.length - 1) {
                    preguntaActual++;
                    mostrarPregunta(preguntaActual);
                }
            });
        }

        if (btnAnterior) {
            btnAnterior.addEventListener('click', () => {
                if (preguntaActual > 0) {
                    preguntaActual--;
                    mostrarPregunta(preguntaActual);
                }
            });
        }
    });

    mostrarPregunta(preguntaActual);
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tiempoLimite = @json($cuestionario->tiempo_limite); // en minutos
        const tiempoDisplay = document.getElementById('tiempoRestante');
        const form = document.querySelector('form');

        if (tiempoLimite) {
            let tiempoRestante = tiempoLimite * 60; // en segundos

            const actualizarTemporizador = () => {
                const minutos = Math.floor(tiempoRestante / 60);
                const segundos = tiempoRestante % 60;
                tiempoDisplay.textContent = `⏳ Tiempo restante: ${minutos}:${segundos.toString().padStart(2, '0')}`;

                if (tiempoRestante <= 0) {
                    tiempoDisplay.textContent = "⏳ Tiempo agotado. Enviando...";
                    form.submit();
                }

                tiempoRestante--;
            };

            actualizarTemporizador();
            setInterval(actualizarTemporizador, 1000);
        }
    });
    </script>




@endsection



@include('layout')
