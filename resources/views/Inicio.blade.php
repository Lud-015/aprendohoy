@section('titulo')
    Área Personal
@endsection

@section('content')
    @if (auth()->user()->hasRole('Administrador'))
        @include('partials.dashboard.admin.estadisticas')
    @endif

    @if (auth()->user()->hasRole('Docente') || auth()->user()->hasRole('Estudiante'))
        @include('partials.dashboard.common.cursos')
    @endif
@endsection

@if (auth()->user()->hasRole('Administrador'))
    @section('contentini')
        @include('partials.dashboard.admin.notificaciones-reportes')
    @endsection
@endif

@if (auth()->user()->hasRole('Docente') || auth()->user()->hasRole('Estudiante'))
    @include('FundacionPlantillaUsu.index')
@endif

@include('botman.tinker')

@if (auth()->user()->hasRole('Administrador'))
    @include('layout')
@endif
