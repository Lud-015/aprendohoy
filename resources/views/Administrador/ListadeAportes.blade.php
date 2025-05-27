@section('titulo', 'Lista de Pagos')
@section('content')
<div class="container-fluid my-4">
    <div class="row mb-3 align-items-center">
        <div class="col-md-4 mb-2">
            <a href="{{ route('registrarpagoadmin') }}" class="btn btn-success w-100">
                <i class="bi bi-plus-circle"></i> Registrar Pago
            </a>
        </div>
        <div class="col-md-8">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" id="searchInput" class="form-control" placeholder="Buscar...">
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="">
                <tr>
                    <th>#</th>
                    <th>Datos Estudiante</th>
                    <th>Fecha del Pago</th>
                    <th>Monto a Pagar</th>
                    <th>Monto Cancelado</th>
                    <th>Comprobante</th>
                    <th>Acciones</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($aportes as $aportes)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $aportes->datosEstudiante }}</td>
                        <td>{{ $aportes->created_at }}</td>
                        <td>{{ $aportes->monto_a_pagar }} Bs.</td>
                        <td>{{ $aportes->monto_pagado }} Bs.</td>
                        <td>
                            <a href="{{ route('descargar.comprobante', basename($aportes->comprobante)) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-download"></i> Descargar
                            </a>
                        </td>
                        <td>
                            <!-- Botón Editar -->
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editarPagoModal{{ $aportes->id }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <!-- Botón Eliminar -->
                            <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $aportes->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                        <td>
                            <form action="{{ route('habilitar.curso', $aportes->id) }}" method="POST" onsubmit="return confirm('¿Confirmas que deseas habilitar este curso para el estudiante?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success" title="Confirmar Pago">
                                    <i class="bi bi-check-circle"></i> Confirmar Pago
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal Editar Pago -->
                    <div class="modal fade" id="editarPagoModal{{ $aportes->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('pagos.update', $aportes->codigopago) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="codigopago" value="{{ $aportes->codigopago }}">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Pago</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>

                                    <div class="modal-body">
                                        <p><strong>Estudiante:</strong> {{ $aportes->user->name }} {{ $aportes->user->lastname1 }} {{ $aportes->user->lastname2 }}</p>
                                        <p><strong>Curso:</strong> {{ $aportes->curso->nombreCurso }}</p>

                                        <div class="mb-3">
                                            <label class="form-label">Monto Pagado:</label>
                                            <input type="number" name="monto_pagado" class="form-control" value="{{ $aportes->monto_pagado }}" step="0.01" required>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            <h5 class="text-muted">No hay pagos registrados</h5>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    // Filtro de búsqueda
    $(document).ready(function () {
        $('#searchInput').on('input', function () {
            var searchText = $(this).val().toLowerCase();
            $('tbody tr').each(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
            });
        });
    });

    // SweetAlert para eliminar
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const pagoId = this.dataset.id;

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminarlo'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/pagos/${pagoId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Eliminado', 'El pago ha sido eliminado.', 'success')
                                    .then(() => window.location.reload());
                            }
                        });
                    }
                });
            });
        });
    });
</script>
@endsection

@include('layout')
