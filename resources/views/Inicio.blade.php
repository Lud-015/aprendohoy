@section('titulo')
    Área Personal
@endsection

<!-- Navigation -->



@section('content')



    @if (auth()->user()->hasRole('Administrador'))
        <div class="m-1 row">
            <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Cursos </h5>
                                <span class="h2 font-weight-bold mb-0">{{ count($cursos) }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Usuarios Estudiantes</h5>
                                <span class="h2 font-weight-bold mb-0">{{ count($estudiantes) }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                    <i class="fas fa-chart-pie"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Usuarios Docentes</h5>
                                <span class="h2 font-weight-bold mb-0">{{ count($docentes) }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Inscripciones de cursos</h5>
                                <span class="h2 font-weight-bold mb-0">{{ count($inscritos) }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                    <i class="fas fa-percent"></i>
                                </div>
                            </div>
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
                            <img src="{{ asset('./assets/img/course-default.jpg') }}" class="w-full h-40 object-cover" alt="Imagen curso">
                            <div class="p-4">
                                <span class="text-sm bg-blue-500 text-white px-2 py-1 rounded">
                                    {{ $inscrito->cursos->institucion ?? 'Nombre Institución' }}
                                </span>
                                <h3 class="text-xl font-semibold mt-2">{{ $inscrito->cursos->nombreCurso }}</h3>
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $inscrito->progreso }}%;"></div>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">{{ $inscrito->progreso }}% completado</p>

                                <a href="{{ route('Curso', $inscrito->cursos_id) }}" class="block text-center mt-4 bg-blue-500 text-white py-2 rounded">
                                    IR AL CURSO
                                </a>
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
                            <img src="{{ asset('./assets/img/course-default.jpg') }}" class="w-full h-40 object-cover" alt="Imagen curso">
                            <div class="p-4">
                                <span class="text-sm bg-blue-500 text-white px-2 py-1 rounded">
                                    Docente
                                </span>
                                <h3 class="text-xl font-semibold mt-2">{{ $cursos->nombreCurso }}</h3>
                                <a href="{{ route('Curso', $cursos->id) }}" class="block text-center mt-4 bg-blue-500 text-white py-2 rounded">
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
    <div class="p-3 row mt-5">
        <div class="col-xl-8 mb-5 mb-xl-0">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Notificaciones</h3>
                        </div>


                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Descripcion</th>
                                <th>Tiempo </th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach (auth()->user()->notifications()->paginate(4) as $notification)
                                <tr>
                                    <th scope="row">
                                        <p>{{ $notification->data['message'] }}</p>
                                    </th>
                                    <td>
                                        <p>{{ $notification->created_at->diffForHumans() }}</p>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <style>
                    .card-footer .pagination-container .page-link svg {
                        width: 14px;
                        /* Ancho del icono */
                        height: 14px;
                        /* Altura del icono */
                    }
                </style>

                <div class="card-footer py-4">
                    <ul class="pagination justify-content-end mb-0 ml-5">
                        {{ Auth::user()->notifications()->paginate(4)->links('custom-pagination') }}
                    </ul>
                </div>


            </div>
        </div>
        <div class="col-xl-4">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Reportes</h3>
                        </div>
                        {{-- <div class="col text-right">
                            <a href="#!" class="btn btn-sm btn-primary">See all</a>
                        </div> --}}
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Nr°</th>
                                <th scope="col">Cursos Finalizados</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($cursos as $cursos)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ ucfirst(strtolower($cursos->nombreCurso)) }}</td>

                                <td>
                                    <a href="{{ route('rfc', [$cursos->id]) }}">
                                        <img src="{{ asset('assets/icons/ojo.png') }}" alt="Ver Icon"
                                            style="width: 16px; height: 16px;">
                                        Ver
                                    </a>
                                </td>



                            </tr>

                        @empty
                            <td>
                                <h4>NO HAY CURSOS REGISTRADOS</h4>
                            </td>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@endif


@if (auth()->user()->hasRole('Docente') || auth()->user()->hasRole('Estudiante'))
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.querySelector("input[placeholder='Buscar']");
        const courseCards = document.querySelectorAll(".bg-white.shadow-lg");
        const sortButton = document.querySelector("button:nth-child(3)");
        const viewToggleButton = document.querySelector("button:nth-child(4)");
        const selectFilter = document.querySelector("select");

        let isAscending = true;
        let currentView = "grid"; // Puede ser 'grid' o 'list'

        // 🔍 Filtrar cursos por nombre en tiempo real
        searchInput.addEventListener("input", function () {
            const query = searchInput.value.toLowerCase();

            courseCards.forEach(card => {
                const title = card.querySelector("h3").textContent.toLowerCase();
                card.style.display = title.includes(query) ? "block" : "none";
            });
        });

        // 🔄 Ordenar los cursos al hacer clic en "Ordenar por nombre"
        sortButton.addEventListener("click", function () {
            const container = document.querySelector(".grid");
            let coursesArray = Array.from(courseCards);

            coursesArray.sort((a, b) => {
                const titleA = a.querySelector("h3").textContent.toLowerCase();
                const titleB = b.querySelector("h3").textContent.toLowerCase();

                return isAscending ? titleA.localeCompare(titleB) : titleB.localeCompare(titleA);
            });

            isAscending = !isAscending; // Alternar el orden

            container.innerHTML = ""; // Limpiar contenedor
            coursesArray.forEach(course => container.appendChild(course));
        });

        // 🖼 Cambiar entre vista de Tarjeta y Lista
        viewToggleButton.addEventListener("click", function () {
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
        selectFilter.addEventListener("change", function () {
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
