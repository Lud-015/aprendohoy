@include('FundacionPlantillaUsu.header')
@include('FundacionPlantillaUsu.navbar')


<h1>Perfil del Usuario</>
<!-- Contenedor de la foto de perfil redondeada -->
<div class="profile-picture-container">
    <img src="{{asset('./resources/img/usuario.jpg')}}" alt="Foto de Perfil">
</div>

<form action="actualizar_perfil.php" method="POST" enctype="multipart/form-data" class="profile-form">
    <div class="section-container">
        <label for="nombre">Nombre:</label>
        <label for="nombre">{{auth()->user()->name}} {{auth()->user()->lastname1}} {{auth()->user()->lastname2}}</label>
    </div>

    <div class="section-container">
        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <label for="fecha_nacimiento">{{auth()->user()->fechadenac}}</label>
    </div>

    <div class="section-container">
        <label for="correo">Correo Electrónico:</label>
        <label for="correo">{{auth()->user()->email}}</label>
    </div>

    <div class="section-container">
        <label for="celular">Celular:</label>
        <label for="celular">{{auth()->user()->Celular}}</label>

    </div>

    <div class="section-container">
        <label for="profesion">Profesión:</label>
        <input type="text" id="profesion" name="profesion">
    </div>

    <div class="section-container">
        <p>Rellena los datos de tus últimas 4 experiencias laborales:</p>
        <table>
            <tr>
                <th>Lugar de Trabajo</th>
                <th>Cargo</th>
                <th>Contacto de Referencia</th>
                <th>Número de Contacto</th>
            </tr>
            <tr>
                <td><input type="text" name="trabajo1_lugar"></td>
                <td><input type="text" name="trabajo1_cargo"></td>
                <td><input type="text" name="trabajo1_referencia"></td>
                <td><input type="tel" name="trabajo1_referencia_numero"></td>
            </tr>
            <tr>
                <td><input type="text" name="trabajo2_lugar"></td>
                <td><input type="text" name="trabajo2_cargo"></td>
                <td><input type="text" name="trabajo2_referencia"></td>
                <td><input type="tel" name="trabajo2_referencia_numero"></td>
            </tr>
            <tr>
                <td><input type="text" name="trabajo3_lugar"></td>
                <td><input type="text" name="trabajo3_cargo"></td>
                <td><input type="text" name="trabajo3_referencia"></td>
                <td><input type="tel" name="trabajo3_referencia_numero"></td>
            </tr>
            <tr>
                <td><input type="text" name="trabajo4_lugar"></td>
                <td><input type="text" name="trabajo4_cargo"></td>
                <td><input type="text" name="trabajo4_referencia"></td>
                <td><input type="tel" name="trabajo4_referencia_numero"></td>
            </tr>
        </table>
    </div>

    <div class="section-container">
        <label for="hoja_vida">Adjuntar Hoja de Vida (PDF):</label>
        <input type="file" id="hoja_vida" name="hoja_vida">
    </div>

    <div class="section-container">
        <input type="submit" class="button-generic" value="Actualizar Perfil">
    </div>
</form>

    @include('FundacionPlantillaUsu.footer')
</body>
</html>
