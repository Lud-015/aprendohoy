@section('titulo')
    Área Personal
@endsection

<!-- Navigation -->



@section('content')



    @if (auth()->user()->hasRole('Administrador'))
        <div class="container py-1">
            <!-- Tarjetas de estadísticas -->
            <div class="row g-2">
                <div class="col-xl-3 col-md-6">
                    <div class="card shadow-sm border-2">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="text-muted text-uppercase mb-1">Cursos</h5>
                                <span class="h2 fw-bold">{{ count($cursos) }}</span>
                            </div>
                            <div class="icon bg-danger text-white rounded-circle p-3">
                                <i class="bi bi-bar-chart-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card shadow-sm border-2">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="text-muted text-uppercase mb-1">Estudiantes</h5>
                                <span class="h2 fw-bold">{{ count($estudiantes) }}</span>
                            </div>
                            <div class="icon bg-warning text-white rounded-circle p-3">
                                <i class="bi bi-people-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card shadow-sm border-2">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="text-muted text-uppercase mb-1">Docentes</h5>
                                <span class="h2 fw-bold">{{ count($docentes) }}</span>
                            </div>
                            <div class="icon bg-primary text-white rounded-circle p-3">
                                <i class="bi bi-person-check-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card shadow-sm border-2">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="text-muted text-uppercase mb-1">Inscripciones</h5>
                                <span class="h2 fw-bold">{{ count($inscritos) }}</span>
                            </div>
                            <div class="icon bg-info text-white rounded-circle p-3">
                                <i class="bi bi-clipboard-check-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    @endif

    @if (auth()->user()->hasRole('Docente') || auth()->user()->hasRole('Estudiante'))
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
            <div
                class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-4 gap-3">
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
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $inscrito->progreso }}%;"></div>
                                    </div>
                                    <small class="text-muted">{{ $inscrito->progreso }}% completado</small>

                                    @if ($inscrito->cursos->tipo == 'congreso')
                                        <a href="{{ route('Curso', $inscrito->cursos_id) }}" class="btn btn-success btn-sm w-100 mt-3">
                                            <i class="bi bi-door-open"></i> Acceder al Congreso
                                        </a>
                                    @elseif($inscrito->pago_completado)
                                        <a href="{{ route('Curso', $inscrito->cursos_id) }}" class="btn btn-primary btn-sm w-100 mt-3">
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
                                                <small class="d-block text-muted mt-1">Estamos verificando tu información</small>
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

            <!-- MODAL (fuera del loop) -->
            <div class="modal fade" id="pagoModal" tabindex="-1" aria-labelledby="pagoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('pagarCurso') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="pagoModalLabel">Completar Compra</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Ocultos -->
                                <input type="hidden" name="inscrito_id" id="modalInscritoId">
                                <input type="hidden" name="estudiante_id" id="modalEstudianteId">
                                <input type="hidden" name="curso_id" id="modalCursoId">

                                <!-- Usuario -->
                                <div class="mb-3">
                                    <label class="form-label">Usuario:</label>
                                    <input type="text" id="modalEstudianteNombre" class="form-control" readonly>
                                </div>

                                <hr>

                                <!-- Curso -->
                                <div class="mb-3">
                                    <label class="form-label">Curso:</label>
                                    <input type="text" id="modalCursoNombre" class="form-control" readonly>
                                </div>

                                <!-- Monto -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Monto a Pagar:</label>
                                        <div class="input-group">
                                            <input type="number" name="montopagar" id="modalCursoPrecio" class="form-control" min="1" step="any" required readonly>
                                            <span class="input-group-text">$</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Comprobante -->
                                <div class="mb-3">
                                    <label class="form-label">Comprobante:</label>
                                    <input type="file" name="comprobante" class="form-control" required>
                                </div>

                                <!-- Descripción -->
                                <div class="mb-3">
                                    <label class="form-label">Descripción:</label>
                                    <textarea name="descripcion" class="form-control" rows="4" required></textarea>
                                </div>

                                <div class="m-3 text-center">
                                    <img src="{{ asset('assets/img/pago.png') }}" alt="Métodos de pago" class="img-fluid">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success">Confirmar Compra</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var pagoModal = document.getElementById('pagoModal');
                    pagoModal.addEventListener('show.bs.modal', function (event) {
                        var button = event.relatedTarget;

                        // Obtener data
                        var inscritoId = button.getAttribute('data-inscrito-id');
                        var cursoId = button.getAttribute('data-curso-id');
                        var cursoNombre = button.getAttribute('data-curso-nombre');
                        var cursoPrecio = button.getAttribute('data-curso-precio');
                        var estudianteNombre = button.getAttribute('data-estudiante-nombre');
                        var estudianteId = button.getAttribute('data-estudiante-id');

                        // Asignar valores
                        document.getElementById('modalInscritoId').value = inscritoId;
                        document.getElementById('modalCursoId').value = cursoId;
                        document.getElementById('modalCursoNombre').value = cursoNombre;
                        document.getElementById('modalCursoPrecio').value = cursoPrecio;
                        document.getElementById('modalEstudianteNombre').value = estudianteNombre;
                        document.getElementById('modalEstudianteId').value = estudianteId;

                        document.getElementById('pagoModalLabel').textContent = 'Pago: ' + cursoNombre;
                    });
                });
            </script>



                @if (auth()->user()->hasRole('Docente'))
                    @forelse ($cursos2 as $cursos)
                        @if (auth()->user()->id == $cursos->docente_id)
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="card h-100 shadow-sm border-0">
                                    <img src="{{ asset('./assets/img/course-default.jpg') }}" class="card-img-top"
                                        style="height: 200px; object-fit: cover;" alt="Imagen curso">
                                    <div class="card-body">
                                        <span class="badge bg-primary mb-2"><i class="bi bi-person-badge"></i>
                                            Docente</span>
                                        <h5 class="card-title text-truncate">{{ $cursos->nombreCurso }}</h5>
                                        <a href="{{ route('Curso', $cursos->id) }}"
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

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const gridBtn = document.getElementById("btnGrid");
                const listBtn = document.getElementById("btnList");
                const courseContainer = document.querySelector(".row.g-4");

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
            });
        </script>


    @endif




@endsection
@if (auth()->user()->hasRole('Administrador'))

    @section('contentini')
        <div class="row mt-5">
            <!-- Notificaciones -->
            <div class="col-xl-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="mb-0">Notificaciones</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="">
                                <tr>
                                    <th>Descripción</th>
                                    <th>Tiempo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (auth()->user()->notifications()->paginate(4) as $notification)
                                    <tr>
                                        <td>{{ $notification->data['message'] }}</td>
                                        <td>{{ $notification->created_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        {{ Auth::user()->notifications()->paginate(4)->links('custom-pagination') }}
                    </div>
                </div>
            </div>

            <!-- Reportes -->
            <div class="col-xl-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="mb-0">Reportes</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="">
                                <tr>
                                    <th>#</th>
                                    <th>Cursos Finalizados</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cursos as $curso)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ ucfirst(strtolower($curso->nombreCurso)) }}</td>
                                        <td>
                                            <a href="{{ route('rfc', [$curso->id]) }}"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-eye"></i> Ver
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <h5>No hay cursos registrados</h5>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @endsection
@endif


@if (auth()->user()->hasRole('Docente') || auth()->user()->hasRole('Estudiante'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.querySelector("input[placeholder='Buscar']");
            const courseCards = document.querySelectorAll(".card.h-100");
            const sortButton = document.querySelector("button:nth-of-type(3)");
            const viewToggleButton = document.querySelector("button:nth-of-type(4)");
            const selectFilter = document.querySelector("select");

            let isAscending = true;
            let currentView = "grid"; // Puede ser 'grid' o 'list'

            // 🔍 Filtrar cursos por nombre
            searchInput.addEventListener("input", function() {
                const query = searchInput.value.toLowerCase();

                courseCards.forEach(card => {
                    const title = card.querySelector(".card-title").textContent.toLowerCase();
                    card.parentElement.style.display = title.includes(query) ? "block" : "none";
                });
            });

            // 🔄 Ordenar cursos por nombre
            sortButton.addEventListener("click", function() {
                const container = document.querySelector(".row.g-4");
                let cardsArray = Array.from(courseCards).map(card => card.parentElement);

                cardsArray.sort((a, b) => {
                    const titleA = a.querySelector(".card-title").textContent.toLowerCase();
                    const titleB = b.querySelector(".card-title").textContent.toLowerCase();
                    return isAscending ? titleA.localeCompare(titleB) : titleB.localeCompare(
                        titleA);
                });

                isAscending = !isAscending;
                container.innerHTML = "";
                cardsArray.forEach(card => container.appendChild(card));
            });

            // 🖼 Cambiar entre vista de Tarjeta y Lista
            viewToggleButton.addEventListener("click", function() {
                const container = document.querySelector(".row.g-4");

                if (currentView === "grid") {
                    container.classList.remove("row", "g-4");
                    container.classList.add("d-flex", "flex-column", "gap-3");
                    courseCards.forEach(card => {
                        card.parentElement.className = "w-100";
                    });
                    currentView = "list";
                    viewToggleButton.textContent = "Tarjeta";
                } else {
                    container.classList.remove("d-flex", "flex-column", "gap-3");
                    container.classList.add("row", "g-4");
                    courseCards.forEach(card => {
                        card.parentElement.className = "col-12 col-md-6 col-lg-4";
                    });
                    currentView = "grid";
                    viewToggleButton.textContent = "Lista";
                }
            });

            // 🎯 Filtrar según estado de curso (completado/activo)
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

    @include('FundacionPlantillaUsu.index')
@endif

@include('botman.tinker')



@if (auth()->user()->hasRole('Administrador'))
    @include('layout')
@endif
