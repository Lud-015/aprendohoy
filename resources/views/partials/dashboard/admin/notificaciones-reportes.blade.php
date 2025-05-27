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