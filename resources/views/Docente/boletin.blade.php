@extends('layout')

@section('titulo')
    Boletín del Estudiante
@endsection

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Boletín del Estudiante</h1>

    <div class="mb-6">
        <p><strong>Nombre del estudiante:</strong> {{ $inscritos->estudiantes->name ?? 'Sin nombre' }} {{ $inscritos->estudiantes->lastname1 ?? 'Sin nombre' }} {{ $inscritos->estudiantes->lastname2 ?? '' }}</p>
        <p><strong>Curso:</strong> {{ $inscritos->cursos->nombreCurso ?? 'Sin curso' }}</p>
    </div>

    @foreach ($notasPorTema as $tema)
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-blue-700 mb-2">Tema: {{ $tema['tema'] }}</h2>

            @foreach ($tema['subtemas'] as $subtema)
                <div class="ml-4 mb-4">
                    <h3 class="text-lg font-medium text-gray-700">Subtema: {{ $subtema['subtema'] }}</h3>

                    @foreach ($subtema['actividades'] as $actividad)
                        <div class="ml-6 mb-2 border-l-2 border-gray-300 pl-4">
                            <p class="font-semibold">Actividad: {{ $actividad['actividad'] }} <span class="text-sm text-gray-500">({{ $actividad['tipo_actividad'] }})</span></p>

                            @if (count($actividad['notas']) > 0)
                                <ul class="list-disc ml-6 text-sm text-gray-700">
                                    @foreach ($actividad['notas'] as $nota)
                                        <li class="mb-1">
                                            <strong>{{ $nota['tipo'] }}:</strong> Nota: {{ $nota['nota'] }},
                                            Fecha: {{ \Carbon\Carbon::parse($nota['fecha'])->format('d/m/Y') }},
                                            Comentario: {{ $nota['comentario'] }}
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-sm text-gray-500">Sin notas registradas.</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endforeach
</div>
@endsection
