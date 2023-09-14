<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foro</title>
    <link rel="stylesheet" href="{{ asset('assets/css/foro.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #E6F7FF; /* Fondo celeste */
        }
        .foro-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #FFFFFF; /* Fondo blanco */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .foro-title {
            font-size: 24px;
            font-weight: bold;
            color: #333; /* Texto oscuro */
            margin-bottom: 20px;
        }
        .comments {
            /* Estilos para los comentarios aquí */
        }
        .comment {
            /* Estilos para cada comentario aquí */
        }
        .author {
            /* Estilos para el autor aquí */
        }
        .comment-text {
            /* Estilos para el texto del comentario aquí */
        }
        .comment-form {
            /* Estilos para el formulario aquí */
        }
    </style>
</head>
<body>
<div class="foro-container">
    <h1 class="foro-title">Foro de Discusión del Curso</h1>

    <!-- Mostrar comentarios de ejemplo -->
    <div class="header">
        <nav class="navbar">
        <div class="navbar-logo">
    <img src="./assets/img/logo2.png" class="navbar-brand-img" alt="...">
</div>
            <a href="{{ route('Inicio') }}" class="nav-link">Inicio</a>
            <a href="{{ route('ListaEstudiantes') }}" class="nav-link">Lista de Estudiantes</a>
            <a href="#" class="nav-link">Crear Estudiante</a>
        </nav>
    </div>
    <div class="comments">
        <div class="comment">
            <p class="author">Autor 1</p>
            <p class="comment-text">Este es un comentario de ejemplo.</p>
        </div>
        <div class="comment">
            <p class="author">Autor 2</p>
            <p class="comment-text">Otro comentario de ejemplo.</p>
        </div>
    </div>

    <!-- Formulario para agregar un comentario -->
    <form class="comment-form">
        <textarea name="content" rows="4" placeholder="Escribe tu comentario aquí"></textarea>
        <button type="submit">Publicar Comentario</button>
    </form>
</div>
</body>
</html>

