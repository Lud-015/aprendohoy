<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Lista de Docentes</title>
</head>
<body>
   
   <a href="{{route('Inicio')}}">Volver a Inicio</a>
   <br>
   @if (auth()->user()->hasRole('Administrador'))
   <a href="{{route('CrearDocente')}}">Crear Docente</a>
   <table>
      <th>
         <td>Nro</td>
         <td>Nombre</td>
         <td>Apellido Paterno</td>
         <td>Apellido Materno</td>
         <td>CI</td>
         <td>Celular</td>
         <td></td>
      </th>
      @foreach ($docente as $docente)
      

         
      <tr>
         <td>{{$loop->iteration}}</td>
         <td>{{$docente->name}}</td>
         <td>{{$docente->lastname1}}</td>
         <td>{{$docente->lastname2}}</td>
         <td>{{$docente->CI}}</td>
         <td>{{$docente->Celular}}</td>
         <td><a href="/Docente/{{$docente->id}}">Ver Mas</a></td>
      </tr>
      <br>

      @endforeach
   </table>
   @else

   <h1>NO ERES ADMINISTRADOR</h1>


   @endif
</body>
</html>