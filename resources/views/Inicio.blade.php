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
                                <h5 class="card-title text-uppercase text-muted mb-0">Alumnos</h5>
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
                                <h5 class="card-title text-uppercase text-muted mb-0">Docentes</h5>
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
                                <h5 class="card-title text-uppercase text-muted mb-0">Inscripciones</h5>
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


    @if (auth()->user()->hasRole('Estudiante'))
        @forelse ($inscritos as $inscrito)
            @if (auth()->user()->id == $inscrito->estudiante_id && $inscrito->cursos && $inscrito->cursos->deleted_at === null)
                <div class="w-full md:w-1/2 xl:w-1/3 p-3">

                    <a href="{{ route('Curso', $inscrito->cursos_id) }}" class="block bg-white border rounded shadow p-2">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded p-3 bg-blue-400"><i class="fa fa-bars fa-2x fa-fw fa-inverse"></i>
                                </div>
                            </div>
                            <div class="flex-1 text-right md:text-center">
                                <h3 class="atma text-3xl">{{ $inscrito->cursos->nombreCurso }} <span
                                        class="text-green-500"></span></h3>
                                <h5 class="alegreya uppercase"></h5>
                                <span class="inline-block mt-2">IR</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        @empty
            <h1>NO TIENES CURSOS ASIGNADOS</h1>
        @endforelse
    @endif

    @if (auth()->user()->hasRole('Docente'))
        @forelse ($cursos2 as $cursos)
            @if (auth()->user()->id == $cursos->docente_id)
                <div class="w-full md:w-1/2 xl:w-1/3 p-3">

                    {{-- <a href="{{ route('Curso', Crypt::encrypt($cursos->id)) }}" class="block bg-white border rounded shadow p-2"> --}}
                    <a href="{{ route('Curso', $cursos->id) }}" class="block bg-white border rounded shadow p-2">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded p-3 bg-blue-400"><i class="fa fa-bars fa-2x fa-fw fa-inverse"></i>
                                </div>
                            </div>
                            <div class="flex-1 text-right md:text-center">
                                <h3 class="atma text-3xl">{{ $cursos->nombreCurso }} <span class="text-green-500"></span>
                                </h3>
                                <h5 class="alegreya uppercase"></h5>
                                <span class="inline-block mt-2">IR</span>
                            </div>
                        </div>
                    </a>
                </div>
            @else
            @endif
        @empty
            <div class="card pb-3 pt-3 col-xl-12">
                <h4>NO TIENES CURSOS ASIGNADOS</h4>
            </div>
        @endforelse
    @endif


    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
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


    @include('FundacionPlantillaUsu.index')
@endif




@if (auth()->user()->hasRole('Administrador'))
    @include('layout')
@endif
