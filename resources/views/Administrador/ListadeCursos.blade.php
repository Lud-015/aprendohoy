<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Lista de Cursos</title>
</head>
<body>
   <a href="{{route('Inicio')}}">VOLVER</a>
   <br>
   <a href="{{route('CrearCurso')}}">CREAR CURSO</a>
   
   <table>

      <tr>
         <th>Nº</th>
         <th>Nombre Curso</th>
         <th>Nivel</th>
         <th>Docente</th>
         <th>EdadDirigida</th>
         <th>Fecha Incializacion</th>
         <th>Fecha Finalizacion</th>
         <th>Formato</th>
      </tr>      
      @foreach ($cursos as $cursos)
      <tr>
         <td>{{$loop->iteration}}</td>
         <td>{{$cursos->nombreCurso}}</td>
         <td>{{$cursos->nivel ? $cursos->nivel->nombre : 'N/A'}}</td>
         <td>{{$cursos->docente->name}} {{$cursos->docente->lastname1}} {{$cursos->docente->lastname2}}</td>
         <td title="{{$cursos->edad_dirigida ? $cursos->edad_dirigida->edad1 : 'N/A'}} - {{$cursos->edad_dirigida ? $cursos->edad_dirigida->edad2 : 'N/A'}}">{{$cursos->edad_dirigida ? $cursos->edad_dirigida->nombre : 'N/A'}}</td>
         <td>{{$cursos->fecha_ini ? $cursos->fecha_ini : 'N/A'}}</td>
         <td>{{$cursos->fecha_fin ? $cursos->fecha_fin : 'N/A'}}</td>
         <td>{{$cursos->formato ? $cursos->formato : 'N/A'}}</td>
         <td><a href="">EDITAR</a></td>
         <td><a href="">BORRAR</a></td>
         <td><a href="">VER</a></td>

      </tr>
      @endforeach
   </table>


</body>
</html>