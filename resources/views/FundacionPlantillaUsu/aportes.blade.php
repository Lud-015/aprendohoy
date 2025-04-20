@section('title')
<h1>PAGOS</h1>

@endsection
@section('content')
<div class="container py-5">
    <h2 class="h4 fw-bold text-center mb-4">Historial de Aportes</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive shadow rounded">
        <table class="table table-bordered table-striped table-hover align-middle mb-0">
            <thead class="table-primary text-center">
                <tr>
                    <th>Estudiante</th>
                    <th>Monto</th>
                    <th>Descripción</th>
                    <th>Comprobante</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($aportes as $aporte)
                    @if ($aporte->estudiante_id == auth()->user()->id)
                        <tr>
                            <td>{{ $aporte->datosEstudiante }}</td>
                            <td>${{ number_format($aporte->monto, 2) }}</td>
                            <td>{{ $aporte->DescripcionDelPago }}</td>
                            <td class="text-center">
                                <a href="{{ route('factura', $aporte->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-file-earmark-text"></i> Ver Factura

                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Aún no se ha realizado ningún pago.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-4 d-flex justify-content-end">
        {{ $aportes->links() }}
    </div>
</div>
@endsection



@include('FundacionPlantillaUsu.index')
</a>