@extends('layout')

@section('content')
<div class="container py-4">
    <!-- Sección de Nivel y Progreso -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h2">Nivel {{ $userXP->current_level ?? 1 }}</h2>
                    <p class="text-muted">{{ $currentLevel->title ?? 'Nivel Inicial' }}</p>
                </div>
                <div style="width: 100px; height: 100px;">
                    <img src="{{ asset($currentLevel->badge_image ?? 'images/badges/default.png') }}" 
                         alt="Insignia de nivel" class="img-fluid">
                </div>
            </div>
            
            <!-- Barra de Progreso -->
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-primary">Progreso al siguiente nivel</span>
                    <span class="small text-primary">{{ $currentXP ?? 0 }}/{{ $nextLevelXP ?? 100 }} XP</span>
                </div>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" 
                         style="width: {{ $progressPercentage ?? 0 }}%" 
                         aria-valuenow="{{ $progressPercentage ?? 0 }}" 
                         aria-valuemin="0" 
                         aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas Rápidas -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h3 class="h5 mb-2">Total XP</h3>
                    <p class="h3 text-primary mb-0">{{ number_format($userXP->current_xp ?? 0) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h3 class="h5 mb-2">Logros Desbloqueados</h3>
                    <p class="h3 text-success mb-0">{{ $unlockedAchievements ?? 0 }}/{{ $totalAchievements ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h3 class="h5 mb-2">Racha Actual</h3>
                    <p class="h3 text-warning mb-0">{{ $currentStreak ?? 0 }} días</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Logros -->
    <div class="card">
        <div class="card-body">
            <h2 class="h3 mb-4">Logros</h2>
            
            <!-- Filtros -->
            <div class="btn-group mb-4">
                <button class="btn btn-primary">Todos</button>
                <button class="btn btn-outline-primary">Desbloqueados</button>
                <button class="btn btn-outline-primary">Bloqueados</button>
            </div>

            <!-- Grid de Logros -->
            <div class="row g-4">
                @forelse($achievements ?? [] as $achievement)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 {{ $achievement->isUnlocked ? 'border-primary' : 'opacity-75' }}">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="display-4 me-3 {{ $achievement->isUnlocked ? '' : 'opacity-50' }}">
                                    {!! $achievement->icon !!}
                                </div>
                                <div>
                                    <h3 class="h6 mb-1">{{ $achievement->title }}</h3>
                                    <p class="small text-muted mb-2">{{ $achievement->description }}</p>
                                    @if($achievement->isUnlocked)
                                        <span class="badge bg-success">
                                            Desbloqueado • {{ $achievement->earned_at->diffForHumans() }}
                                        </span>
                                    @else
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar" role="progressbar" 
                                                 style="width: {{ ($achievement->progress / $achievement->requirement_value) * 100 }}%"></div>
                                        </div>
                                        <small class="text-muted">
                                            {{ $achievement->progress }}/{{ $achievement->requirement_value }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                            @if($achievement->isUnlocked)
                                <div class="position-absolute top-0 end-0 p-2">
                                    <span class="badge bg-primary">+{{ $achievement->xp_reward }} XP</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        No hay logros disponibles en este momento.
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Tabla de Niveles -->
    <div class="card mt-4">
        <div class="card-body">
            <h2 class="h3 mb-4">Progresión de Niveles</h2>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nivel</th>
                            <th>Título</th>
                            <th>XP Requerido</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($levels ?? [] as $level)
                        <tr class="{{ $level->level_number == ($currentLevel->level_number ?? 0) ? 'table-primary' : '' }}">
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset($level->badge_image ?? 'images/badges/default.png') }}" 
                                         alt="Nivel {{ $level->level_number }}" 
                                         class="me-2" style="width: 30px; height: 30px;">
                                    {{ $level->level_number }}
                                </div>
                            </td>
                            <td>
                                <div>{{ $level->title }}</div>
                                <small class="text-muted">{{ $level->description }}</small>
                            </td>
                            <td>{{ number_format($level->required_xp) }} XP</td>
                            <td>
                                @if($level->level_number < ($currentLevel->level_number ?? 1))
                                    <span class="badge bg-success">Completado</span>
                                @elseif($level->level_number == ($currentLevel->level_number ?? 1))
                                    <span class="badge bg-primary">Actual</span>
                                @else
                                    <span class="badge bg-secondary">Bloqueado</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                <div class="alert alert-info mb-0">
                                    No hay niveles disponibles en este momento.
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.card {
    transition: transform 0.2s;
}
.card:hover {
    transform: translateY(-5px);
}
</style>
@endpush
@endsection 