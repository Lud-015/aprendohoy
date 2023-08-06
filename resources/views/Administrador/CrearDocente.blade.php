<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Crear Docente</title>
</head>
<body>
   <a href="{{route('Inicio')}}">Inicio</a>/<a href="{{route('ListaDocentes')}}">Lista de Docentes</a>/Crear Docentes

   <hr>

   <form method="post">
   @csrf   
   @if (auth()->user()->hasRole('Administrador'))
   <label for="">Nombre</label>
   <input type="text" name="name">
   <br>
   <label for="" >Apellido Paterno</label>
   <input type="text" name="lastname1">
   <br>
   <label for="">Apellido Materno</label>
   <input type="text" name="lastname2">
   <br>
   <label for="">CI</label>
   <input type="text" name="CI">
   <br>
   <label for="">Celular</label>
   <input type="text" name="Celular">
   <br>
   <label for="">Fecha de Nacimiento</label>
   <input type="text" name="fechadenac">
   <br>
   <label for="">Correo Electronico</label>
   <input type="text" name="email">
   <br>  
   <input type="submit" value="Crear Docente">
   </form>
   @else
   
   <h1>NO ERES ADMINISTRADOR</h1> 
   
   @endif
   
 
</body>
</html>