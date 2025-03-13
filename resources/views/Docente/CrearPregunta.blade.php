

@section('content')
    <div class="border p-3">
        <a href="javascript:history.back()" class="btn btn-primary">
            &#9668; Volver
        </a>
        <br>
        <div class="tareadocente-container">
            <div class="title">
                <h2>Crear Pregunta y Respuestas</h2>

            </div>

            <div class="">
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="fileUpload">Tipo de Respuesta:</label>
                        <input type="radio" name="tipo" value="short"> Respuesta Corta
                        /
                        <input type="radio" name="tipo" value="verdaderofalso" checked> Verdadero y Falso
                        /
                        <input type="radio" name="tipo" value="multiple"> Selección Multiple
                    </div>
                    <input type="text" name="tarea_id" value="{{ $tarea->id }}" hidden>
                    <div class="form-group">
                        <label for="taskTitle">Pregunta:</label>
                        <input type="text" id="taskTitle" name="pregunta" required>
                    </div>


                    <div class="form-group ">
                        <label for="points">Puntos de pregunta:</label>
                        <input type="number" id="points" name="puntos" required>
                    </div>

                    <div class="form-group" id="short">
                        <label for="points">Respuesta Correcta:</label>
                        <input class="col-8" type="text" id="points" name="respuestaCorrectashort">
                    </div>

                    <div class="form-group" id="multiple">
                        <label for="points">Respuesta Correcta:</label>
                        <input class="col-8" type="text" id="points" name="respuestaCorrecta">
                    </div>

                    <div class="form-group" id="vf-form">
                        <label for="points">Respuesta Correcta:</label>
                        <input type="radio" id="points" name="vf" value="Verdadero">Verdadero
                        <input type="radio" id="points" name="vf" value="Falso">Falso

                    </div>


                    <div id="respuestas" class="form-group" id="mult-form">
                        <!-- Este div se usa para agregar respuestas dinámicamente -->
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



        <script>
            // Función para mostrar u ocultar los campos dependiendo del tipo de pregunta seleccionado
            function toggleCampos() {
                var tipoPregunta = document.querySelector('input[name="tipo"]:checked').value;

                // Mostrar u ocultar campos según el tipo de pregunta seleccionado
                if (tipoPregunta === 'multiple') {
                    document.getElementById('respuestas').style.display = 'block';
                    document.getElementById('multiple').style.display = 'block';
                    document.getElementById('vf-form').style.display = 'none';
                    document.getElementById('short').style.display = 'none';
                } else if (tipoPregunta === 'verdaderofalso') {
                    document.getElementById('respuestas').style.display = 'none';
                    document.getElementById('vf-form').style.display = 'block';
                    document.getElementById('multiple').style.display = 'none';
                    document.getElementById('short').style.display = 'none';

                } else {
                    document.getElementById('short').style.display = 'block';

                    document.getElementById('respuestas').style.display = 'none';
                    document.getElementById('vf-form').style.display = 'none';
                    document.getElementById('multiple').style.display = 'none';

                }
            }

            // Llamar a la función al cargar la página para establecer el estado inicial
            toggleCampos();

            // Agregar oyentes de eventos a los radios para cambiar los campos visibles cuando cambia el tipo de pregunta
            var radios = document.querySelectorAll('input[name="tipo"]');
            radios.forEach(function(radio) {
                radio.addEventListener('change', toggleCampos);
            });
        </script>
    @endsection

    @include('layout')
