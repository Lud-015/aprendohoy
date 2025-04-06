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

        <div class="container mx-auto p-4">
            <h2 class="text-2xl font-bold mb-4">Vista general de curso</h2>

            <div class="flex items-center mb-4 space-x-2">
                <select class="border p-2 rounded">
                    <option value="all">Todos</option>
                </select>
                <input type="text" placeholder="Buscar" class="border p-2 rounded w-1/3">
                <button class="border p-2 rounded bg-gray-200">Ordenar por nombre del curso</button>
                <button class="border p-2 rounded bg-gray-200">Tarjeta</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @if (auth()->user()->hasRole('Estudiante'))
                    @forelse ($inscritos as $inscrito)
                        @if (auth()->user()->id == $inscrito->estudiante_id && $inscrito->cursos && $inscrito->cursos->deleted_at === null)
                            <div class="bg-white shadow-lg rounded-lg overflow-hidden">

                                <img src="{{ $inscrito->cursos->imagen ? asset('storage/' . $inscrito->cursos->imagen) : asset('./assets/img/course-default.jpg') }}"
                                class="w-full h-40 object-cover"
                                alt="Imagen curso">
                                <div class="p-4">
                                    <h3 class="text-xl font-semibold mt-2">{{ $inscrito->cursos->nombreCurso }}</h3>

                                    <!-- Mostrar etiqueta si es congreso -->
                                    @if ($inscrito->cursos->tipo == 'congreso')
                                        <span
                                            class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded mb-2">
                                            <i class="bi bi-ticket-perforated"></i> Evento Gratuito
                                        </span>
                                    @endif

                                    <!-- Barra de progreso -->
                                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                        <div class="bg-blue-500 h-2 rounded-full"
                                            style="width: {{ $inscrito->progreso }}%;"></div>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">{{ $inscrito->progreso }}% completado</p>

                                    <!-- Lógica de acceso -->
                                    @if ($inscrito->cursos->tipo == 'congreso')
                                        <!-- Acceso directo para congresos -->
                                        <a href="{{ route('Curso', $inscrito->cursos_id) }}"
                                            class="block text-center mt-4 bg-green-500 hover:bg-green-600 text-white py-2 rounded transition">
                                            <i class="bi bi-door-open"></i> ACCEDER AL CONGRESO
                                        </a>
                                    @elseif($inscrito->pago_completado)
                                        <!-- Acceso para cursos pagados -->
                                        <a href="{{ route('Curso', $inscrito->cursos_id) }}"
                                            class="block text-center mt-4 bg-blue-500 hover:bg-blue-600 text-white py-2 rounded transition">
                                            <i class="bi bi-play-circle"></i> IR AL CURSO
                                        </a>
                                    @else
                                        <!-- Estados para cursos no pagados -->
                                        <div class="text-center mt-4">
                                            @if ($inscrito->created_at->diffInDays(now()) < 2)
                                                <button
                                                    class="w-full bg-yellow-500 text-white py-2 rounded cursor-not-allowed"
                                                    disabled>
                                                    <i class="bi bi-hourglass"></i> PAGO EN REVISIÓN
                                                </button>
                                                <p class="text-xs text-gray-500 mt-1">Estamos verificando tu información</p>
                                            @else
                                                <button class="w-full bg-red-500 text-white py-2 rounded cursor-not-allowed"
                                                    disabled>
                                                    <i class="bi bi-lock"></i> PENDIENTE DE PAGO
                                                </button>
                                                <a href=""
                                                    class="inline-block mt-2 text-blue-500 hover:text-blue-700 text-sm">
                                                    <i class="bi bi-credit-card"></i> Completar pago ahora
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @empty
                        <p class="col-span-3 text-center text-gray-500">No tienes cursos asignados.</p>
                    @endforelse
                @endif

                @if (auth()->user()->hasRole('Docente'))
                    @forelse ($cursos2 as $cursos)
                        @if (auth()->user()->id == $cursos->docente_id)
                            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                                <img src="{{ asset('./assets/img/course-default.jpg') }}" class="w-full h-40 object-cover"
                                    alt="Imagen curso">
                                <div class="p-4">
                                    <span class="text-sm bg-blue-500 text-white px-2 py-1 rounded">
                                        Docente
                                    </span>
                                    <h3 class="text-xl font-semibold mt-2">{{ $cursos->nombreCurso }}</h3>
                                    <a href="{{ route('Curso', $cursos->id) }}"
                                        class="block text-center mt-4 bg-blue-500 text-white py-2 rounded">
                                        IR AL CURSO
                                    </a>
                                </div>
                            </div>
                        @endif
                    @empty
                        <p class="col-span-3 text-center text-gray-500">No tienes cursos asignados.</p>
                    @endforelse
                @endif
            </div>
        </div>
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
                            <thead class="table-dark">
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
                            <thead class="table-dark">
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
            const courseCards = document.querySelectorAll(".bg-white.shadow-lg");
            const sortButton = document.querySelector("button:nth-child(3)");
            const viewToggleButton = document.querySelector("button:nth-child(4)");
            const selectFilter = document.querySelector("select");

            let isAscending = true;
            let currentView = "grid"; // Puede ser 'grid' o 'list'

            // 🔍 Filtrar cursos por nombre en tiempo real
            searchInput.addEventListener("input", function() {
                const query = searchInput.value.toLowerCase();

                courseCards.forEach(card => {
                    const title = card.querySelector("h3").textContent.toLowerCase();
                    card.style.display = title.includes(query) ? "block" : "none";
                });
            });

            // 🔄 Ordenar los cursos al hacer clic en "Ordenar por nombre"
            sortButton.addEventListener("click", function() {
                const container = document.querySelector(".grid");
                let coursesArray = Array.from(courseCards);

                coursesArray.sort((a, b) => {
                    const titleA = a.querySelector("h3").textContent.toLowerCase();
                    const titleB = b.querySelector("h3").textContent.toLowerCase();

                    return isAscending ? titleA.localeCompare(titleB) : titleB.localeCompare(
                    titleA);
                });

                isAscending = !isAscending; // Alternar el orden

                container.innerHTML = ""; // Limpiar contenedor
                coursesArray.forEach(course => container.appendChild(course));
            });

            // 🖼 Cambiar entre vista de Tarjeta y Lista
            viewToggleButton.addEventListener("click", function() {
                const container = document.querySelector(".grid");

                if (currentView === "grid") {
                    container.classList.remove("grid-cols-1", "md:grid-cols-2", "lg:grid-cols-3");
                    container.classList.add("flex", "flex-col", "space-y-4");
                    currentView = "list";
                    viewToggleButton.textContent = "Tarjeta";
                } else {
                    container.classList.remove("flex", "flex-col", "space-y-4");
                    container.classList.add("grid", "grid-cols-1", "md:grid-cols-2", "lg:grid-cols-3");
                    currentView = "grid";
                    viewToggleButton.textContent = "Lista";
                }
            });

            // 🎯 Filtrar cursos según la selección
            selectFilter.addEventListener("change", function() {
                const filterValue = selectFilter.value; // Captura el valor del filtro

                courseCards.forEach(card => {
                    if (filterValue === "all") {
                        card.style.display = "block";
                    } else {
                        const completionText = card.querySelector("p.text-sm").textContent;
                        const isCompleted = completionText.includes("100%");

                        if (filterValue === "completados" && isCompleted) {
                            card.style.display = "block";
                        } else if (filterValue === "activos" && !isCompleted) {
                            card.style.display = "block";
                        } else {
                            card.style.display = "none";
                        }
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
