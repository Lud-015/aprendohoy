<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Listas de Curso</title>
</head>
<body>
   
   @if (auth()->user()->hasRole('Administrador'))
   <a href="{{route('CrearCurso')}}">Crear Curso</a>
   @endif

   <table>
      <th>
         <td>a</td>
         <td>a</td>
         <td>a</td>
         <td>a</td>
      </th>
      <tr>
         <td>c</td>
         <td>c</td>
         <td>c</td>
         <td>c</td>
      </tr>
   </table>

</body>
</html>