
@include('FundacionPlantillaUsu.header')
@include('FundacionPlantillaUsu.navbar')


<h1>Inscribir Alumno</h1>

<p>Selecciona un curso y un alumno para inscribir:</p>

<form action="procesar_inscripcion.php" method="POST">
    <div class="select-container">
        <div>
            <select id="curso" name="curso" required>
                <option value="curso1">Curso 1</option>
                <option value="curso2">Curso 2</option>
                <option value="curso3">Curso 3</option>
                <!-- Agrega más cursos según sea necesario -->
            </select>
        </div>

        <div>
            <select id="alumno" name="alumno" required>
                <option value="alumno1">Alumno 1</option>
                <option value="alumno2">Alumno 2</option>
                <option value="alumno3">Alumno 3</option>
                <!-- Agrega más alumnos según sea necesario -->
            </select>
        </div>
    </div>

    <br><br>

    <input type="submit" class="button-generic" value="Inscribir Alumno">
</form>
    @include('FundacionPlantillaUsu.footer') ?>

</body>
</html>
