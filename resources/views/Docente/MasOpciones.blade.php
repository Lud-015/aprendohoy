@extends('EditarPerfil')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar Perfil</title>
</head>

<body>


   <h1>EDITAR PERFIL</h1>
    <form action="{{route('')}}" method="POST" >
        @csrf
         <h4>Datos Personales</h4>
        <br>
        <input type="text" value="{{ auth()->user()->Celular }}" name="Celular">
        <br>
        <input type="text" value="{{ auth()->user()->fechadenac }}" name="fechadenac">
        <br>
        <br>


        <br>
      @if (auth()->user()->hasRole('Docente') or auth()->user()->hasRole('Administrador'))

      @foreach ($atributosD as $atributosD)

      <input type="text" placeholder="Formacion Academica" name="formacion" value="{{ $atributosD->formacion }}">
      <br>
      <input type="text" placeholder="Experiencia Laboral" name="Especializacion"  value="{{ $atributosD->Especializacion }}">
      <br>
      <input type="text"  placeholder="Especilaizacion" name="ExperienciaL" value="{{ $atributosD->ExperienciaL }}">
      <br>

      @endforeach
      @endif
      <br><br>
      <br>
      <input type="password" name="confirmpassword" placeholder="Contraseña">
      <br><br>
      <input type="submit" value="EDITAR PERFIL">

    </form>


</body>

</html>
