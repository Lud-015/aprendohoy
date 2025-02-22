@section('titulo')
    Registrar Aporte
@endsection



@section('content')
    <div class="p-4  bordertable-container">
        <h1>Tabla de Aportes/Pagos</h1>



        <form action="{{ route('registrarpagopost') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label >Nombre / Razon Social:</label>
            <input type="text" name="pagante" required>

            <label >CI :</label>
            <input type="number" name="paganteci"  required>


            <hr>
            <input type="text" id="estudiante_id" name="estudiante_id" value="{{ auth()->user()->id }}" hidden>

            <label for="nombre_estudiante">Curso:</label>
            <select name="curso_id" id="estudiante_id">
                    @forelse ($cursos as $curso)
                        <option value="{{ $curso->id }}">{{ $curso->nombreCurso }} </option>
                    @empty
                        <option value="">No hay cursos disponibles</option>
                    @endforelse
            </select>

            <label for="nombre_estudiante">Nombre del Estudiante:</label>
            <select name="estudiante_id" id="estudiante_id">
                    @forelse ($estudiantes as $estudiante)
                        <option value="{{ $estudiante->id }}">{{ $estudiante->name }} {{ $estudiante->lastname1 }} {{ $estudiante->lastname2 }}</option>
                    @empty
                        <option value="">No hay estudiantes registrados</option>
                    @endforelse
            </select>






            <div style="flex: auto;">
                <label for="monto">Monto a Pagar:</label>
                <input type="number" id="monto" name="montopagar" min="1" step="any" required>
                <span>Bs.</span>
            </div>

            <div style="flex: auto;">
                <label for="monto">Monto Cancelado:</label>
                <input type="number" id="monto" name="montocancelado" min="1" step="any" required>
                <span>Bs.</span>
            </div>


                <label for="descripcion">Descripción:</label>
                <br>
            <textarea  id="descripcion" name="descripcion" rows="6" cols="50"   required ></textarea><br><br>

            <input class="btn btn-success" type="submit" class="button-generic" value="Guardar">
        </form>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>





@endsection




@include('layout')
