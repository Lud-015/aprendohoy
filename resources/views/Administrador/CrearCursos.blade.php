<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>CrearCurso</title>
</head>
<body>

<h1>CREAR CURSO</h1>

<form action="" method="POST">

   @csrf
   <label  el for="">Nombre Curso</label>
   <input type="text" name="nombre"><br>
   <label for="">Descripcion Curso</label>
   <input type="text" name="descripcion"><br>
   <label for="">Fecha Inicio</label>
   <input type="text" name="fecha_ini"><br>
   <label for="">Fecha Fin</label>
   <input type="text" name="fecha_fin"><br>
   <label for="">Formato</label>
   <select name="formato" id="">
      <option value="Presencial">Presencial</option>
      <option value="Virtual">Virtual</option>
      <option value="Hibrido">Hibrido</option>
   </select>
   <br>
   <label for="">Docente</label>
   <select name="docente_id" id="">
      @foreach ($docente as $docente)
          <option value="{{$docente->id}}">{{$docente->name}}  {{$docente->lastname1}} {{$docente->lastname2}}</option>
      @endforeach
   </select>
   <br>
   <label for="">Edad Dirigida</label>
   <select name="edad_id" id="">
      @foreach ($edad as $edad)
          <option value="{{$edad->id}}">{{$edad->nombre}}  {{$edad->edad1}}  ENTRE  {{$edad->edad2}}</option>
          @endforeach
   </select>
   <br>
   <label for="">Niveles</label>
   
   <select name="nivel_id" id="">
      @foreach ($niveles as $niveles)
          <option value="{{$niveles->id}}">{{$niveles->nombre}}  </option>
      @endforeach
   </select>
      
   <br>
   <label for="">Horarios</label>
   <select name="horario_id" id="">
      @foreach ($horario as $horario)
          <option value="{{$horario->id}}">{{$horario->dias}} de {{$horario->hora_ini}} a {{$horario->hora_fin}}  </option>
      @endforeach
   </select>
   <br>
   <br>
   <input type="submit" value="Crear Curso">


</form>

   
</body>
</html>