
@section('Titulo')
Editar Pregunta
@endsection




@section('content')
    <div class="border p-3">
        <a href="javascript:history.back()" class="btn btn-primary">
            &#9668; Volver
        </a>
        <br>
        <div class="tareadocente-container">
            <div class="title">
                <h2>Editar Pregunta </h2>

            </div>

            <div class="">
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $pregunta->id }}">
                    <div class="form-group" hidden>
                        <label for="fileUpload">Tipo de Respuesta:</label>
                        <input type="radio" name="tipo" value="short"   @if ($pregunta->tipo_preg == 'short') checked @endif> Respuesta Corta
                        /
                        <input type="radio" name="tipo" value="verdaderofalso" @if ($pregunta->tipo_preg == 'vf') checked @endif > Verdadero y Falso
                        /
                        <input type="radio" name="tipo" value="multiple" @if ($pregunta->tipo_preg == 'multiple') checked @endif> Selección Multiple
                    </div>
                    <input type="text" name="tarea_id" value="{{ $pregunta->tarea_id }}" hidden>
                    <div class="form-group">
                        <label for="taskTitle">Pregunta:</label>
                        <input type="text" id="taskTitle" name="pregunta" value="{{ $pregunta->texto_pregunta }}" required>
                    </div>


                    <div class="form-group ">
                        <label for="points">Puntos de pregunta:</label>
                        <input type="number" id="points" name="puntos" value="{{ $pregunta->puntos }}" required>
                    </div>








                    <br>


                    <input class="btn btn-success" type="submit" placeholder="Guardar" value="Guardar"></input>
                </form>
            </div>



            <style>
                .tareadocente-container {
                    background-color: #fff;
                    border: 1px solid #ccc;
                    border-radius: 10px;
                    padding: 20px;
                    margin: 20px;
                }

                .title {
                    text-align: left;
                }

                .task-form {
                    width: 100%;
                    max-width: 400px;
                    text-align: left;
                    margin-top: 20px;
                }

                .task-form h2 {
                    margin-bottom: 20px;
                    font-size: 24px;
                }

                .form-group {
                    margin-bottom: 20px;
                }

                label {
                    display: block;
                    font-weight: bold;
                    margin-bottom: 5px;
                }

                input[type="text"],
                textarea,
                input[type="date"],
                input[type="number"],
                input[type="file"] {
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    font-size: 16px;
                }

                input[type="checkbox"] {
                    margin-top: 5px;
                }

                button {
                    background-color: #007BFF;
                    color: #fff;
                    border: none;
                    border-radius: 5px;
                    padding: 10px 20px;
                    font-size: 18px;
                    cursor: pointer;
                }

                button:hover {
                    background-color: #0056b3;
                }
            </style>


        </div>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <h2 class="bg-danger alert-danger">{{ $error }}</h2>
            @endforeach
        @endif




    @endsection

    @include('layout')
