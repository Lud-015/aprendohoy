<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Inicio</title>
</head>
<body>

   <header>

      <h1>Bienvenida {{auth()->user()->name}}</h1>
      <h1>{{auth()->user()->getRoleNames()}}</h1>
   
      @if (auth()->user()->hasRole('Administrador'))
      <ul>
         <li>Perfil</li>
         <li><a href="{{route('ListadeCursos')}}">Lista de Cursos</a></li>
         <li> <a href="{{route('ListaDocentes')}}">Docentes</a></li>
         <li>Estudiantes</li>
         <li>Aportes</li>
         <li> <a href="">Reportes</a> </li>
         <li><a href="{{route('logout')}}">Cerrar Sesion</a></li>
      </ul>  
      @endif
   
      
      @if (auth()->user()->hasRole('Docente'))
      <ul>
         <li>Perfil</li>
         <li>Mis Cursos</li>
         <li> <a href="">Reportes</a> </li>
         <li><a href="{{route('logout')}}">Cerrar Sesion</a></li>
   
      </ul>
   
         
      @endif
   
      
      @if (auth()->user()->hasRole('Estudiantes'))
      <ul>
         <li>Perfil</li>
         <li>Cursos</li>
         <li>Estudiantes</li>
         <li>Aportes</li>
         <li> <a href="">Reportes</a> </li>
         <li><a href="{{route('logout')}}">Cerrar Sesion</a></li>
      </ul>
    
      @endif
   
   
      @if (auth()->user()->hasRole('EnEspera'))
      <ul>
         <li>Perfil</li>
         <li>Docentes</li>
         <li>Estudiantes</li>
         <li>Aportes</li>
         <li> <a href="">Reportes</a> </li>
         <li><a href="{{route('logout')}}">Cerrar Sesion</a></li>
      </ul>
    
      @endif
   

   </header>
   <hr>
   <div>
      <div>

      
         @if (auth()->user()->hasRole('Administrador'))




         @endif
      
         
         @if (auth()->user()->hasRole('Docente'))
            <div>
            <h2>Mis Cursos</h2>
            </div>

            @foreach ($cursos as $cursos)
            @if (auth()->user()->id = $cursos->docente_id)
               
            <table class="table table-light">
               <tbody>
                  <tr>
                     <td>{{$cursos->nombreCurso}}</td>
                  </tr>
                  <tr>
                     <td>{{$cursos->descripcionC}}</td>
                  </tr>
                  <tr>
                     <td> <a href="Cursos/id/{{$cursos->id}}">IR A CURSO</a> </td>
                  </tr>
               </tbody>
            </table>

            @else

            <h1>NO TIENES CURSOS ASIGNADOS</h1>

            
            @endif
            @endforeach
            
            
         @endif
      
         
         @if (auth()->user()->hasRole('Estudiantes'))

       
         @endif
      
      
         @if (auth()->user()->hasRole('EnEspera'))
    
         
         
         @endif
      





      </div>
   </div>
   
</body>
</html>