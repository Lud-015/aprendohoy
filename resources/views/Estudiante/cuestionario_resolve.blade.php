@section('content')
    <div class="progress mb-4">
        <div class="progress-bar" role="progressbar" style="width: 0%;" id="progressBar"></div>
    </div>

    <form method="POST" action="{{ route('responderCuestionario', $cuestionario->id) }}">
        @csrf
        @foreach ($cuestionario->preguntas as $pregunta)
            <div class="card mb-4 pregunta" id="pregunta-{{ $loop->index }}"
                style="{{ $loop->index > 0 ? 'display: none;' : '' }}">
                <div class="card-body">
                    <h5 class="card-title">Pregunta {{ $loop->iteration }}: {{ $pregunta->pregunta }}</h5>
                    <p class="card-text">Puntos: {{ $pregunta->puntaje }}</p>

                    @if ($pregunta->tipo === 'opcion_multiple')
                        @foreach ($pregunta->respuestas as $respuesta)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="respuestas[{{ $pregunta->id }}]"
                                    id="respuesta{{ $respuesta->id }}" value="{{ $respuesta->id }}">
                                <label class="form-check-label" for="respuesta{{ $respuesta->id }}">
                                    {{ $respuesta->contenido }}
                                </label>
                            </div>
                        @endforeach
                    @elseif ($pregunta->tipo === 'boolean')
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="respuestas[{{ $pregunta->id }}]"
                                id="verdadero{{ $pregunta->id }}" value="1">
                            <label class="form-check-label" for="verdadero{{ $pregunta->id }}">
                                Verdadero
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="respuestas[{{ $pregunta->id }}]"
                                id="falso{{ $pregunta->id }}" value="0">
                            <label class="form-check-label" for="falso{{ $pregunta->id }}">
                                Falso
                            </label>
                        </div>
                    @else
                        <div class="form-group">
                            <textarea class="form-control" name="respuestas[{{ $pregunta->id }}]" rows="3"
                                placeholder="Escribe tu respuesta aquí..."></textarea>
                        </div>
                    @endif

                    <div class="mt-3">
                        @if (!$loop->first)
                            <button type="button" class="btn btn-secondary btn-anterior">Anterior</button>
                        @endif
                        @if (!$loop->last)
                            <button type="button" class="btn btn-primary btn-siguiente">Siguiente</button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn btn-success mt-4">Enviar Respuestas</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let formSubmitted = false;

            // Detectar si el formulario se envía
            const form = document.querySelector('form');
            form.addEventListener('submit', function () {
                formSubmitted = true;
            });

            // Advertencia al intentar salir de la página
            window.addEventListener('beforeunload', function (e) {
                if (!formSubmitted) {
                    e.preventDefault();
                    e.returnValue = ''; // Algunos navegadores requieren esta línea para mostrar la advertencia
                    alert('Si abandonas esta página, tu intento será finalizado con una nota de 0.');
                }
            });

            // Mostrar la primera pregunta al cargar
            const preguntas = document.querySelectorAll('.pregunta');
            const progressBar = document.getElementById('progressBar');
            let preguntaActual = 0;

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
                        preguntaActual++;
                        mostrarPregunta(preguntaActual);
                    });
                }

                if (btnAnterior) {
                    btnAnterior.addEventListener('click', () => {
                        preguntaActual--;
                        mostrarPregunta(preguntaActual);
                    });
                }
            });

            mostrarPregunta(preguntaActual);
        });
    </script>
@endsection


@include('layout')
