@extends('FundacionPlantillaUsu.index')


@section('content')
<div class="container py-4">
    <div class="row g-4">
        @forelse ($cursos2 as $curso)
            @if (auth()->user()->id == $curso->docente_id)
                <div class="col-12 col-md-6 col-xl-4">
                    <a href="{{ route('rfc', $curso->id) }}" class="text-decoration-none">
                        <div class="card h-100 shadow-sm border-0 hover-shadow">
                            <div class="card-body d-flex align-items-center">
                                <!-- Icono -->
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <i class="bi bi-journal-text fs-4"></i>
                                </div>

                                <!-- Info -->
                                <div>
                                    <h5 class="card-title text-dark mb-1">{{ $curso->nombreCurso }}</h5>
                                    <small class="text-muted">Docente asignado</small>
                                </div>

                                <!-- Flecha derecha -->
                                <div class="ms-auto text-primary">
                                    <i class="bi bi-arrow-right-circle fs-5"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle-fill me-2"></i> No tienes cursos asignados.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection

