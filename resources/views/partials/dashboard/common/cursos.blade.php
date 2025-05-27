<style>
    .list-view .card {
        flex-direction: row;
        align-items: center;
    }

    .list-view .card img {
        width: 200px;
        height: 100%;
        object-fit: cover;
        border-radius: 0;
    }

    .list-view .card-body {
        flex: 1;
    }

    .list-view .col-12,
    .list-view .col-sm-6,
    .list-view .col-lg-4 {
        flex: 0 0 100%;
        max-width: 100%;
    }
</style>

<div class="container py-5">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-4 gap-3">
        <h2 class="h4 fw-semibold mb-0">Tus Cursos</h2>

        <div class="d-flex flex-wrap align-items-center gap-2">
            <select class="form-select form-select-sm w-auto">
                <option value="all">Todos</option>
            </select>
            <input type="text" placeholder="Buscar" class="form-control form-control-sm w-auto"
                style="min-width: 200px;">
            <div class="btn-group" role="group">
                <button id="btnGrid" class="btn btn-outline-secondary btn-sm active">
                    <i class="bi bi-grid-3x3-gap-fill"></i>
                </button>
                <button id="btnList" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-list-ul"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @if (auth()->user()->hasRole('Estudiante'))
            @forelse ($inscritos as $inscrito)
                @if (auth()->user()->id == $inscrito->estudiante_id && $inscrito->cursos && $inscrito->cursos->deleted_at === null)
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="{{ $inscrito->cursos->imagen ? asset('storage/' . $inscrito->cursos->imagen) : asset('./assets/img/course-default.jpg') }}"
                                class="card-img-top" style="height: 200px; object-fit: cover;" alt="Imagen curso">
                            <div class="card-body">
                                <h5 class="card-title text-truncate">{{ $inscrito->cursos->nombreCurso }}</h5>

                                @if ($inscrito->cursos->tipo == 'congreso')
                                    <span class="badge bg-success mb-2">
                                        <i class="bi bi-ticket-perforated"></i> Evento Gratuito
                                    </span>
                                @endif

                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: {{ $inscrito->progreso }}%;"></div>
                                </div>
                                <small class="text-muted">{{ $inscrito->progreso }}% completado</small>

                                @if ($inscrito->cursos->tipo == 'congreso')
                                    <a href="{{ route('congreso.detalle', $inscrito->cursos_id) }}"
                                        class="btn btn-success btn-sm w-100 mt-3">
                                        <i class="bi bi-door-open"></i> Acceder al Congreso
                                    </a>
                                @elseif($inscrito->pago_completado)
                                    <a href="{{ route('Curso', $inscrito->cursos_id) }}"
                                        class="btn btn-primary btn-sm w-100 mt-3">
                                        <i class="bi bi-play-circle"></i> Ir al Curso
                                    </a>
                                @else
                                    <button type="button" class="btn btn-primary btn-sm w-100 mt-3"
                                        data-bs-toggle="modal" data-bs-target="#pagoModal"
                                        data-inscrito-id="{{ $inscrito->id }}"
                                        data-curso-id="{{ $inscrito->cursos->id }}"
                                        data-curso-nombre="{{ $inscrito->cursos->nombreCurso }}"
                                        data-curso-precio="{{ $inscrito->cursos->precio }}"
                                        data-estudiante-nombre="{{ auth()->user()->name }} {{ auth()->user()->lastname1 }} {{ auth()->user()->lastname2 }}"
                                        data-estudiante-id="{{ auth()->user()->id }}">
                                        <i class="bi bi-credit-card"></i> Completar Pago
                                    </button>

                                    @if ($inscrito->created_at->diffInDays(now()) < 2)
                                        <div class="text-center mt-3">
                                            <button class="btn btn-warning btn-sm w-100" disabled>
                                                <i class="bi bi-hourglass-split"></i> Pago en Revisión
                                            </button>
                                            <small class="d-block text-muted mt-1">Estamos verificando tu
                                                información</small>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="col-12 text-center text-muted">No tienes cursos asignados.</div>
            @endforelse
        @endif

        @if (auth()->user()->hasRole('Docente'))
            @forelse ($cursos as $curso)
                @if (auth()->user()->id == $curso->docente_id)
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="{{ asset('./assets/img/course-default.jpg') }}" class="card-img-top"
                                style="height: 200px; object-fit: cover;" alt="Imagen curso">
                            <div class="card-body">
                                <span class="badge bg-primary mb-2"><i class="bi bi-person-badge"></i>
                                    Docente</span>
                                <h5 class="card-title text-truncate">{{ $curso->nombreCurso }}</h5>
                                <a href="{{ route('Curso', $curso->id) }}"
                                    class="btn btn-primary btn-sm w-100 mt-3">
                                    <i class="bi bi-arrow-right-circle"></i> Ir al Curso
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="col-12 text-center text-muted">No tienes cursos asignados.</div>
            @endforelse
        @endif
    </div>
</div>

<!-- Modal de Pago -->
@include('partials.dashboard.common.modal-pago')

<!-- Scripts -->
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const gridBtn = document.getElementById("btnGrid");
        const listBtn = document.getElementById("btnList");
        const courseContainer = document.querySelector(".row.g-4");
        const searchInput = document.querySelector("input[placeholder='Buscar']");
        const courseCards = document.querySelectorAll(".card.h-100");
        const selectFilter = document.querySelector("select");

        // Vista Grid/Lista
        gridBtn.addEventListener("click", () => {
            courseContainer.classList.remove("list-view");
            gridBtn.classList.add("active");
            listBtn.classList.remove("active");
        });

        listBtn.addEventListener("click", () => {
            courseContainer.classList.add("list-view");
            gridBtn.classList.remove("active");
            listBtn.classList.add("active");
        });

        // Búsqueda
        searchInput.addEventListener("input", function() {
            const query = searchInput.value.toLowerCase();
            courseCards.forEach(card => {
                const title = card.querySelector(".card-title").textContent.toLowerCase();
                card.parentElement.style.display = title.includes(query) ? "block" : "none";
            });
        });

        // Filtro
        selectFilter.addEventListener("change", function() {
            const filterValue = selectFilter.value;
            courseCards.forEach(card => {
                const progressText = card.querySelector("small.text-muted");
                const isCompleted = progressText && progressText.textContent.includes("100%");
                const wrapper = card.parentElement;

                if (filterValue === "all") {
                    wrapper.style.display = "block";
                } else if (filterValue === "completados" && isCompleted) {
                    wrapper.style.display = "block";
                } else if (filterValue === "activos" && !isCompleted) {
                    wrapper.style.display = "block";
                } else {
                    wrapper.style.display = "none";
                }
            });
        });
    });
</script>
@endpush 