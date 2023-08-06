<!DOCTYPE html>
<html lang="en">
<head>
   
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Cursos de {{$cursos->nombreCurso}}</title>
</head>
<body>
   
   <header>
      <a href="{{route('Inicio')}}">Volver a Inicio</a>
      <h1>{{$cursos->nombreCurso}}</h1>
      <h2>{{$cursos->descripcionC}}</h2>

      @if (auth()->user()->hasPermissionTo('Publicar Tareas'))
      <h4><a href="">CREAR TAREAS</a></h4>
      <h4><a href="">CREAR RECURSO</a></h4>
      @endif
      <h4><a href="">Ver Participantes</a></h4>

   </header>
   <hr>
   <div>
   <h4>RECURSOS</h4>
   </div>
   <hr>
   <div>
      <h4>TAREAS</h4>
   </div>


</body>
</html>