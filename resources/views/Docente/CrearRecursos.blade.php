<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Crear Recursos</title>
</head>
<body>
   <label for="">Nombre Recurso</label>
   <input type="text">
   <label for="">Descripcion Recurso</label>
   <input type="text">
   <label for="">Nombre Recurso</label>
   <input type="text">

   @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

</body>

</html>
