@section('titulo')

Lista de Evaluaciones Eliminadas

@endsection



@section('content')
<div class="col-lg-12 row">

    <form class="navbar-search navbar-search form-inline mr-3 d-none d-md-flex ml-lg-auto">
        <div class="input-group input-group-alternative">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
          </div>
          <input class="form-control" placeholder="Buscar" type="text">
        </div>
    </form>
</div>
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Nro</th>
                            <th scope="col">Tarea</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($evaluaciones as $evaluaciones)
                        <tr>

                            <td scope="row">

                                {{ $loop->iteration }}

                            </td>
                            <td scope="row">
                                {{$evaluaciones->titulo_evaluacion}}

                            </td>

                            <td>


                                <a href="{{ route('restaurarEvaluacion', [$evaluaciones->id])}}">Restaurar Tarea</a>

                            </td>
                        </tr>


                        @empty
                        <tr>

                            <td>

                                <h4>No hay evaluaciones eliminadas</h4>

                            </td>
                        </tr>




                        @endforelse


                    </tbody>
                </table>

                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif



@endsection

@include('layout')
