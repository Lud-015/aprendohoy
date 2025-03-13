@section('titulo')
    Foro de Discusión de {{ $foro->nombreForo }}
@endsection




@section('content')
    <div class="container my-5">
        <!-- Back Button -->
        <a href="{{ route('Curso', ['id' => $foro->cursos->id]) }}" class="btn btn-primary mb-3"
            aria-label="Volver al curso">
            <i class="bi bi-arrow-left" aria-hidden="true"></i>
            <span>Volver</span>
        </a>
        <button class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#commentModal">
            <i class="bi bi-plus-circle"></i> Comentar
        </button>



        <!-- Forum Description -->
        <div class="p-4 mb-4 bg-light rounded shadow-sm border">
            <h4 class="text-secondary mb-3">Descripción del Foro</h4>
            <div class="form-control border-0 bg-transparent">
                {!! nl2br(e($foro->descripcionForo)) !!}
            </div>
        </div>

        <!-- Messages Section -->
        <h3 class="mb-4">Mensajes</h3>
        <div class="messages-container">
            @forelse ($forosmensajes as $mensaje)
                <article class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <!-- Mensaje Principal -->
                        <header class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title text-primary mb-0">
                                <strong>{{ $mensaje->estudiantes->name }} {{ $mensaje->estudiantes->lastname1 }} {{ $mensaje->estudiantes->lastname2 }}</strong>
                                <span class="text-muted"> - {{ $mensaje->tituloMensaje }}</span>
                            </h5>
                            <small class="text-muted">{{ $mensaje->created_at->format('d/m/Y H:i') }}</small>
                        </header>
                        <p class="card-text text-black mb-0">{{ $mensaje->mensaje }}</p>

                        <!-- Botón para abrir modal de respuesta -->
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#replyModal-{{ $mensaje->id }}">
                                <i class="bi bi-reply-fill"></i> Responder
                            </button>
                            <!-- Botón para abrir el modal de edición -->
                            <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editMessageModal-{{ $mensaje->id }}">
                                Editar
                            </button>

                            <!-- Formulario para eliminar -->
                            <form action="{{ route('foro.mensaje.delete', $mensaje->id) }}" method="POST"
                                onsubmit="return confirm('¿Estás seguro de eliminar este mensaje?')">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash-fill"></i> Eliminar
                                </button>
                            </form>
                        </div>


                        <!-- Modal para responder -->
                        <div class="modal fade" id="replyModal-{{ $mensaje->id }}" tabindex="-1"
                            aria-labelledby="replyModalLabel-{{ $mensaje->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="replyModalLabel-{{ $mensaje->id }}">
                                            Responder a {{ $mensaje->tituloMensaje }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('foro.mensaje.store', $foro->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="foro_id" value="{{ $foro->id }}">
                                            <input type="hidden" name="estudiante_id" value="{{ auth()->id() }}">
                                            <input type="hidden" name="respuesta_a" value="{{ $mensaje->id }}">

                                            <div class="mb-3">
                                                <label for="tituloMensaje" class="form-label">Título</label>
                                                <input type="text" class="form-control" name="tituloMensaje"
                                                    placeholder="Re: {{ $mensaje->tituloMensaje }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="mensaje" class="form-label">Mensaje</label>
                                                <textarea class="form-control" name="mensaje" rows="4" placeholder="Escribe tu respuesta aquí" required></textarea>
                                            </div>

                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-send-fill"></i> Enviar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>



                        @if ($mensaje->respuestas->count() > 0)
                            <div class="replies-container ms-4 mt-3">
                                @foreach ($mensaje->respuestas as $respuesta)
                                    <div class="card mb-2 bg-light">
                                        <div class="card-body py-2">
                                            <header class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="card-title mb-1">
                                                    <strong>{{ $respuesta->estudiantes->name }}  {{ $respuesta->estudiantes->lastname1 }} {{ $respuesta->estudiantes->lastname2 }} </strong>
                                                    <small class="text-muted"> -
                                                        {{ $respuesta->created_at->format('d/m/Y H:i') }}</small>

                                                </h6>

                                                <div class="d-flex gap-2">
                                                    <!-- Botón para abrir el modal de edición -->
                                                    <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#editRespuestaModal-{{ $respuesta->id }}">
                                                        <i class="bi bi-pencil-fill"></i> Editar
                                                    </button>

                                                    <!-- Formulario para eliminar -->
                                                    <form action="{{ route('foro.respuesta.delete', $respuesta->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('¿Estás seguro de eliminar esta respuesta?')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                                            <i class="bi bi-trash-fill"></i> Eliminar
                                                        </button>
                                                    </form>
                                                </div>
                                            </header>
                                            <span class="text-muted">{{ $respuesta->tituloMensaje }}</span>
                                            <p class="card-text">{{ $respuesta->mensaje }}</p>
                                        </div>
                                    </div>

                                    <!-- Modal para editar respuesta -->
                                    <div class="modal fade" id="editRespuestaModal-{{ $respuesta->id }}" tabindex="-1"
                                        aria-labelledby="editRespuestaModalLabel-{{ $respuesta->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="editRespuestaModalLabel-{{ $respuesta->id }}">Editar Respuesta
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Cerrar"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('foro.respuesta.edit', $respuesta->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="tituloMensaje" class="form-label fw-bold">Título
                                                                de respuesta</label>
                                                            <input type="text" class="form-control"
                                                                name="tituloMensaje"
                                                                value="{{ $respuesta->tituloMensaje }}" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="mensaje"
                                                                class="form-label fw-bold">Mensaje</label>
                                                            <textarea class="form-control" name="mensaje" rows="4" required>{{ $respuesta->mensaje }}</textarea>
                                                        </div>

                                                        <button type="submit" class="btn btn-primary w-100">
                                                            <i class="bi bi-save-fill"></i> Guardar Cambios
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif



                    </div>
                </article>
                <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="commentModalLabel">Publicar Comentario</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulario de comentario -->
                                <form class="comment-form" method="POST"
                                    action="{{ route('foro.mensaje.store', $foro->id) }}">
                                    @csrf
                                    <input type="hidden" name="foro_id" value="{{ $foro->id }}">
                                    <input type="hidden" name="estudiante_id" value="{{ auth()->user()->id }}">

                                    <div class="mb-3">
                                        <label for="tituloMensaje" class="form-label fw-bold">Título de mensaje</label>
                                        <input type="text" class="form-control" name="tituloMensaje"
                                            placeholder="Título del Mensaje" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="mensaje" class="form-label fw-bold">Mensaje</label>
                                        <textarea class="form-control" name="mensaje" cols="100" rows="4"
                                            placeholder="Escribe tu comentario aquí" required></textarea>
                                    </div>

                                    <button class="btn btn-primary w-100" type="submit">
                                        <i class="bi bi-send-fill"></i> Publicar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="editMessageModal-{{ $mensaje->id }}" tabindex="-1"
                    aria-labelledby="editMessageModalLabel-{{ $mensaje->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editMessageModalLabel-{{ $mensaje->id }}">Editar Mensaje
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('foro.mensaje.edit', $mensaje->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="tituloMensaje" class="form-label fw-bold">Título de mensaje</label>
                                        <input type="text" class="form-control" name="tituloMensaje"
                                            value="{{ $mensaje->tituloMensaje }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="mensaje" class="form-label fw-bold">Mensaje</label>
                                        <textarea class="form-control" name="mensaje" rows="4" required>{{ $mensaje->mensaje }}</textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-save-fill"></i> Guardar Cambios
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">No hay mensajes en este foro.</div>
            @endforelse
        </div>



    </div>
@endsection



<script>
    function showReplyForm(messageId) {
        document.getElementById(`replyForm-${messageId}`).style.display = 'block';
    }

    function hideReplyForm(messageId) {
        document.getElementById(`replyForm-${messageId}`).style.display = 'none';
    }
</script>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


@include('layout')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
