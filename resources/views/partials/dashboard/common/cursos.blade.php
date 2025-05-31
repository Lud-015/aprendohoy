@php
    $userRole = auth()->user()->getRoleNames()->first();
    $hasNoCourses = ($userRole === 'Estudiante' && $inscritos->isEmpty()) ||
                    ($userRole === 'Docente' && $cursos->isEmpty());
@endphp

<style>
    :root {
        --card-transition: transform 0.3s ease, box-shadow 0.3s ease;
        --card-shadow: 0 10px 20px rgba(26, 71, 137, 0.1);
        --card-border-radius: 8px;
    }

    /* Vista de lista */
    .list-view .card {
        flex-direction: row;
        height: 200px !important;
        transition: var(--card-transition);
    }

    .list-view .card img {
        width: 280px;
        height: 100%;
        object-fit: cover;
        border-radius: var(--card-border-radius) 0 0 var(--card-border-radius);
    }

    .list-view [class*="col-"] {
        flex: 0 0 100%;
        max-width: 100%;
    }

    /* Estilos de tarjeta comunes */
    .card {
        transition: var(--card-transition);
        border-radius: var(--card-border-radius);
        border: none;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-shadow);
    }

    .card-img-top {
        transition: transform 0.3s ease;
        height: 200px;
        object-fit: cover;
    }

    .card:hover .card-img-top {
        transform: scale(1.05);
    }

    /* Controles de vista */
    .view-controls {
        gap: 0.5rem;
    }

    .view-btn {
        width: 40px;
        height: 40px;
        border-radius: var(--card-border-radius);
        transition: all 0.3s ease;
        background: white;
        border: 1px solid #dee2e6;
        color: var(--primary-color);
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .view-btn:hover, .view-btn.active {
        background: var(--primary-color);
        color: white;
    }

    /* Barra de progreso */
    .progress {
        height: 6px;
        border-radius: 10px;
        background-color: rgba(26, 71, 137, 0.1);
    }

    .progress-bar {
        background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
    }

    /* Badges y estados */
    .badge {
        padding: 0.5em 1em;
        border-radius: 6px;
        font-weight: 500;
    }

    .badge.bg-success {
        background: rgba(25, 135, 84, 0.1) !important;
        color: #198754;
    }

    .badge.bg-primary {
        background: rgba(26, 71, 137, 0.1) !important;
        color: var(--primary-color);
    }

    /* Animaciones */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .course-item {
        animation: fadeInUp 0.5s ease forwards;
    }
</style>

<div class="container py-5">
    {{-- Encabezado y Controles --}}
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-4 gap-3">
        <h2 class="h4 fw-bold mb-0 text-primary">
            <i class="bi bi-collection-play me-2"></i>Tus Cursos
        </h2>

        <div class="d-flex flex-wrap align-items-center gap-3">
            {{-- Filtros --}}
            <div class="d-flex gap-3 flex-wrap">
                <select class="form-select form-select-sm" style="min-width: 150px;" id="courseFilter">
                    <option value="all">Todos los cursos</option>
                    <option value="activos">En progreso</option>
                    <option value="completados">Completados</option>
                </select>

                <div class="position-relative">
                    <i class="bi bi-search position-absolute" style="left: 10px; top: 50%; transform: translateY(-50%);"></i>
                    <input type="search" id="courseSearch" placeholder="Buscar curso..."
                           class="form-control form-control-sm ps-4" style="min-width: 200px;">
                </div>
            </div>

            {{-- Controles de vista --}}
            <div class="btn-group view-controls">
                <button id="btnGrid" class="view-btn active" title="Vista de cuadrícula">
                    <i class="bi bi-grid-3x3-gap-fill"></i>
                </button>
                <button id="btnList" class="view-btn" title="Vista de lista">
                    <i class="bi bi-list-ul"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Contenedor de cursos --}}
    <div class="row g-4" id="coursesContainer">
        @if($hasNoCourses)
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-journal-x display-4 text-muted mb-3"></i>
                    <h5 class="text-muted">No tienes cursos asignados</h5>
                    <p class="text-muted mb-3">
                        @if($userRole === 'Estudiante')
                            ¡Explora nuestro catálogo y comienza tu aprendizaje!
                        @else
                            Contacta con el administrador para más información.
                        @endif
                    </p>
                    @if($userRole === 'Estudiante')
                        <a href="{{ route('lista.cursos.congresos') }}" class="btn btn-primary">
                            <i class="bi bi-search me-1"></i> Explorar Cursos
                        </a>
                    @endif
                </div>
            </div>
        @else
            @if($userRole === 'Estudiante')
                @foreach($inscritos as $inscrito)
                    @if(auth()->user()->id == $inscrito->estudiante_id && $inscrito->cursos && !$inscrito->cursos->deleted_at)
                        <div class="col-12 col-sm-6 col-lg-4 course-item" data-progress="{{ $inscrito->progreso }}">
                            <div class="card h-100 shadow-sm">
                                <div class="position-relative overflow-hidden">
                                    <img src="{{ $inscrito->cursos->imagen ? asset('storage/' . $inscrito->cursos->imagen) : asset('./assets/img/course-default.jpg') }}"
                                         class="card-img-top" alt="{{ $inscrito->cursos->nombreCurso }}">
                                    @if($inscrito->progreso == 100)
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle-fill"></i> Completado
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold text-truncate mb-2">{{ $inscrito->cursos->nombreCurso }}</h5>
                                    <p class="text-muted small mb-3">
                                        <i class="bi bi-calendar-event me-1"></i>
                                        Inscrito el {{ $inscrito->created_at->format('d/m/Y') }}
                                    </p>

                                    @if($inscrito->cursos->tipo == 'congreso')
                                        <span class="badge bg-success mb-3">
                                            <i class="bi bi-ticket-perforated"></i> Evento Gratuito
                                        </span>
                                    @endif

                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="small text-muted">Progreso</span>
                                            <span class="small fw-bold text-primary">{{ $inscrito->progreso }}%</span>
                                        </div>
                                        <div class="progress mb-3">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $inscrito->progreso }}%"></div>
                                        </div>

                                        @if($inscrito->cursos->tipo == 'congreso')
                                            <a href="{{ route('congreso.detalle', $inscrito->cursos_id) }}"
                                               class="btn btn-success btn-sm w-100">
                                                <i class="bi bi-door-open"></i> Acceder al Congreso
                                            </a>
                                        @elseif($inscrito->pago_completado)
                                            <a href="{{ route('Curso', $inscrito->cursos_id) }}"
                                               class="btn btn-primary btn-sm w-100">
                                                <i class="bi bi-play-circle"></i> Continuar Curso
                                            </a>
                                        @else
                                            <button type="button" class="btn btn-primary btn-sm w-100"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#pagoModal"
                                                    data-inscrito-id="{{ $inscrito->id }}"
                                                    data-curso-id="{{ $inscrito->cursos->id }}"
                                                    data-curso-nombre="{{ $inscrito->cursos->nombreCurso }}"
                                                    data-curso-precio="{{ $inscrito->cursos->precio }}"
                                                    data-estudiante-nombre="{{ auth()->user()->name }} {{ auth()->user()->lastname1 }} {{ auth()->user()->lastname2 }}"
                                                    data-estudiante-id="{{ auth()->user()->id }}">
                                                <i class="bi bi-credit-card"></i> Completar Pago
                                            </button>

                                            @if($inscrito->created_at->diffInDays(now()) < 2)
                                                <div class="alert alert-warning mt-2 p-2 small text-center">
                                                    <i class="bi bi-hourglass-split me-1"></i>
                                                    Pago en revisión
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                @foreach($cursos as $curso)
                    @if(auth()->user()->id == $curso->docente_id)
                        <div class="col-12 col-sm-6 col-lg-4 course-item">
                            <div class="card h-100 shadow-sm">
                                <div class="position-relative overflow-hidden">
                                    <img src="{{ $curso->imagen ? asset('storage/' . $curso->imagen) : asset('./assets/img/course-default.jpg') }}"
                                         class="card-img-top" alt="{{ $curso->nombreCurso }}">
                                    <span class="position-absolute top-0 start-0 m-2 badge bg-primary">
                                        <i class="bi bi-person-badge"></i> Docente
                                    </span>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold text-truncate mb-2">{{ $curso->nombreCurso }}</h5>
                                    <p class="text-muted small mb-3">
                                        <i class="bi bi-people me-1"></i>
                                        {{ $curso->inscritos_count ?? 0 }} estudiantes inscritos
                                    </p>
                                    <a href="{{ route('Curso', $curso->id) }}"
                                       class="btn btn-primary btn-sm w-100 mt-auto">
                                        <i class="bi bi-arrow-right-circle"></i> Gestionar Curso
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        @endif
    </div>
</div>

@if($userRole === 'Estudiante')
    @include('partials.dashboard.common.modal-pago')
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const elements = {
        gridBtn: document.getElementById('btnGrid'),
        listBtn: document.getElementById('btnList'),
        container: document.getElementById('coursesContainer'),
        searchInput: document.getElementById('courseSearch'),
        filterSelect: document.getElementById('courseFilter')
    };

    const viewManager = {
        init() {
            this.loadPreference();
            this.bindEvents();
        },

        loadPreference() {
            try {
                const view = localStorage.getItem('courseViewPreference');
                if (view === 'list') {
                    this.setListView();
                }
            } catch (e) {
                console.warn('Error loading view preference:', e);
            }
        },

        savePreference(view) {
            try {
                localStorage.setItem('courseViewPreference', view);
            } catch (e) {
                console.warn('Error saving view preference:', e);
            }
        },

        setGridView() {
            elements.container.classList.remove('list-view');
            elements.gridBtn.classList.add('active');
            elements.listBtn.classList.remove('active');
            this.savePreference('grid');
        },

        setListView() {
            elements.container.classList.add('list-view');
            elements.gridBtn.classList.remove('active');
            elements.listBtn.classList.add('active');
            this.savePreference('list');
            this.adjustListViewImages();
        },

        adjustListViewImages() {
            const images = elements.container.querySelectorAll('.card img');
            images.forEach(img => {
                img.style.height = elements.container.classList.contains('list-view') ? '200px' : '';
            });
        },

        bindEvents() {
            elements.gridBtn?.addEventListener('click', () => this.setGridView());
            elements.listBtn?.addEventListener('click', () => this.setListView());
            window.addEventListener('resize', () => this.adjustListViewImages());
        }
    };

    const filterManager = {
        init() {
            this.bindEvents();
        },

        filterCourses() {
            const query = elements.searchInput?.value.toLowerCase();
            const filter = elements.filterSelect?.value;
            const items = document.querySelectorAll('.course-item');

            items.forEach(item => {
                const title = item.querySelector('.card-title')?.textContent.toLowerCase();
                const progress = parseInt(item.dataset.progress) || 0;

                const matchesSearch = !query || title?.includes(query);
                const matchesFilter = this.matchesProgressFilter(progress, filter);

                item.style.display = (matchesSearch && matchesFilter) ? '' : 'none';
            });
        },

        matchesProgressFilter(progress, filter) {
            if (!filter || filter === 'all') return true;
            if (filter === 'completados') return progress === 100;
            if (filter === 'activos') return progress < 100;
            return true;
        },

        bindEvents() {
            elements.searchInput?.addEventListener('input', () => this.filterCourses());
            elements.filterSelect?.addEventListener('change', () => this.filterCourses());
        }
    };

    // Inicializar
    viewManager.init();
    filterManager.init();
});
</script>