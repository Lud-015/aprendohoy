@section('titulo')
    Lista de Aportes / Pagos
@endsection




@section('content')
    <div class="col-lg-12 row">
        <form class="navbar-search navbar-search form-inline mr-3 d-none d-md-flex ml-lg-auto">

            <a class="btn btn-sm btn-check" href="{{ route('registrarpagoadmin') }}">Registrar Pago</a>
            <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>

                <input class="form-control" placeholder="Buscar" type="text" id="searchInput">
            </div>
        </form>
    </div>



    <table class="table align-items-center table-flush">
        <thead class="thead-light">
            <tr>
                <th scope="col">Nro</th>
                <th scope="col">Datos Estudiante</th>
                <th scope="col">Fecha del Pago</th>
                <th scope="col">Monto a pagar</th>
                <th scope="col">Monto Cancelado</th>
                <th scope="col">Comprobante</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($aportes as $aportes)
                <tr>

                    <td scope="row">
                        {{ $loop->iteration }}
                    </td>
                    <td scope="row">
                        {{ $aportes->datosEstudiante }}
                    </td>
                    <td>
                        {{ $aportes->created_at }}

                    </td>
                    <td>

                        {{ $aportes->monto_a_pagar }} Bs.
                    </td>
                    <td>
                        {{ $aportes->monto_pagado }} Bs.

                    </td>
                    <td><a href="{{ route('descargar.comprobante', basename($aportes->comprobante)) }}"
                            class="btn btn-sm btn-primary">
                            <i class="fas fa-download"></i> Descargar
                        </a></td>
                    <td>
                        <!-- Botón Editar (abre modal) -->
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                            data-bs-target="#editarPagoModal{{ $aportes->id }}">
                            <i class="fa fa-edit"></i>
                        </button>

                        <!-- Botón Eliminar (SweetAlert) -->
                        <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $aportes->id }}">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>

                        <!-- Modal para Editar -->
                        <div class="modal fade" id="editarPagoModal{{ $aportes->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Pago </h5>


                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="m-3">
                                        <label for="">Nombre Estudiante: {{$aportes->user->name}} {{$aportes->user->lastname1}} {{$aportes->user->lastname2}}</label>
                                        <label for="">Curso: {{ $aportes->curso->nombreCurso }}</label>

                                    </div>
                                    <form action=" {{ route('pagos.update', $aportes->codigopago) }}" method="POST"
                                        >
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="codigopago" value="{{$aportes->codigopago}}" readonly hidden>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Monto Pagado:</label>
                                                <input type="number" name="monto_pagado" class="form-control"
                                                    value="{{ $aportes->monto_pagado }}" step="0.01" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                </tr>
            @empty
                <td>
                    <h4>No hay pagos registrados</h4>
                </td>
            @endforelse

        </tbody>
    </table>


    <!-- Agrega esto en tu archivo Blade antes de </body> -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        $(document).ready(function() {
            // Manejo del evento de entrada en el campo de búsqueda
            $('input[type="text"]').on('input', function() {
                var searchText = $(this).val().toLowerCase();

                // Filtra las filas de la tabla basándote en el valor del campo de búsqueda
                $('tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Eliminar con SweetAlert
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    const pagoId = this.getAttribute('data-id');

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminarlo!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Enviar solicitud DELETE
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
                                        Swal.fire(
                                            'Eliminado!',
                                            'El pago ha sido eliminado.',
                                            'success'
                                        ).then(() => window.location.reload());
                                    }
                                });
                        }
                    });
                });
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Manejo del evento de entrada en el campo de búsqueda
            $('.search-input').on('input', function() {
                var searchText = $(this).val().toLowerCase();

                // Filtra las filas de la tabla basándote en el valor del campo de búsqueda
                $('tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
                });
            });
        });
    </script>
@endsection

@include('layout')
