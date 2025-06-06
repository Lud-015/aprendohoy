@php
    $notifications = auth()->user()->notifications()->paginate(8);
@endphp
<div class="row mb-3">
    <div class="col-md-4">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" class="form-control search-input" placeholder="Buscar notificaciones...">
        </div>
    </div>
    <div class="col-md-4">
        <select class="form-select filter-select">
            <option value="all">Todas las notificaciones</option>
            <option value="unread">No leídas</option>
            <option value="read">Leídas</option>
        </select>
    </div>
    <div class="col-md-4 text-end">
        <button class="btn btn-outline-secondary btn-sm me-2" data-action="mark-all-read">
            <i class="bi bi-check-all"></i> Marcar todo como leído
        </button>
        <button class="btn btn-outline-danger btn-sm" data-action="delete-all-read">
            <i class="bi bi-trash"></i> Eliminar leídas
        </button>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Tiempo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($notifications as $notification)
                <tr class="{{ $notification->read_at ? '' : 'table-light' }} notification-row"
                    data-notification-id="{{ $notification->id }}">
                    <td>
                        <div class="d-flex align-items-center">
                            <i class="bi {{ $notification->data['icon'] ?? 'bi-info-circle' }} me-2 text-primary"></i>
                            <span>{{ $notification->data['message'] }}</span>
                        </div>
                    </td>
                    <td>
                        <span data-bs-toggle="tooltip" title="{{ $notification->created_at }}">
                            {{ $notification->created_at->diffForHumans() }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $notification->read_at ? 'bg-secondary' : 'bg-primary' }}">
                            {{ $notification->read_at ? 'Leído' : 'No leído' }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-outline-primary btn-sm"
                                    data-action="view"
                                    data-id="{{ $notification->id }}"
                                    data-bs-toggle="tooltip"
                                    title="Ver detalles">
                                <i class="bi bi-eye"></i>
                            </button>
                            @if(!$notification->read_at)
                                <button class="btn btn-outline-success btn-sm"
                                        data-action="mark-read"
                                        data-id="{{ $notification->id }}"
                                        data-bs-toggle="tooltip"
                                        title="Marcar como leído">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            @endif
                            <button class="btn btn-outline-danger btn-sm"
                                    data-action="delete"
                                    data-id="{{ $notification->id }}"
                                    data-bs-toggle="tooltip"
                                    title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                            <button class="btn btn-outline-warning btn-sm"
                                    data-action="undo"
                                    data-id="{{ $notification->id }}"
                                    data-bs-toggle="tooltip"
                                    title="Deshacer"
                                    style="display: none;">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4">
                        <div class="empty-state">
                            <i class="bi bi-bell-slash display-4 text-muted"></i>
                            <p class="mt-3 mb-0">No hay notificaciones para mostrar</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-between align-items-center mt-3">
    <div>
        Mostrando {{ $notifications->firstItem() ?? 0 }} -
        {{ $notifications->lastItem() ?? 0 }} de
        {{ $notifications->total() }} notificaciones
    </div>
    <div>
        {{ $notifications->links('vendor.pagination.custom') }}
    </div>
</div>
