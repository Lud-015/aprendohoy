

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>INICIAR SESION</title>
</head>
<body>


@if (auth()->check())


<a href="{{route('logout')}}">Cerrar Sesion</a>


<h1>YA INICIASTE SESION </h1>


@else

<h1>INICIAR SESIÓN</h1>

   <form method="POST">
      @csrf
      <label for="">Correo Electronico</label>
      <br>
      <input type="text" name="email">
      <br>
      <label for="">Contraseña</label>
      <br>
      <input type="password" name="password">
      <br>
      <br>
      <a href="">Olvidaste la contraseña</a>
      <br>
      <br>
      <a href="">No tienes cuenta? Crea Una</a>
      <br>
      <br>
      <button class="btn btn-danger btn-block btn-round">Inciar Sesion</button>

   </form>



@endif
   </body>
</html>


