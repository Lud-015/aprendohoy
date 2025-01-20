<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fundación Cursos</title>
    <link rel="stylesheet" href="{{asset('./resources/css/styles.css')}}">
</head>

    <style>
        /* Estilos del menú */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #63becf;
            padding: 15px;
        }

        .menu-icon {
            display: none;
            cursor: pointer;
        }

        .menu {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        .menu li {
            color: white;
        }

        /* Estilos para pantallas pequeñas */
        @media only screen and (max-width: 768px) {
            .menu {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 70px;
                left: 0;
                right: 0;
                background-color: #333;
                padding: 10px;
            }

            .menu.show {
                display: flex;
            }

            .menu li {
                margin: 10px 0;
            }

            .menu-icon {
                display: block;
            }
        }
    </style>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar">
        <div class="menu-icon">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
        <ul class="menu menu-hamburguesa">
            <h1>Bienvenid@</h1>
            <li class="dropdown">
                <!-- Botón desplegable -->
                <a class="navbar-button dropdown-button" href="#">
                    <img src="{{ asset('assets/icons/user.png') }}" alt="User Icon" style="width: 16px; margin-right: 10px;">
                    {{ auth()->user()->name }} {{ auth()->user()->lastname1 }} &#9660;
                </a>

                <!-- Contenido del botón desplegable -->
                <div class="dropdown-content">
                    <a href="{{ route('Miperfil') }}">
                        <img src="{{ asset('assets/icons/perfil.png') }}" alt="Mi Perfil Icon" style="width: 24px; margin-right: 10px;">
                        Mi Perfil
                    </a>
                    <a href="{{ route('logout') }}">
                        <img src="{{ asset('assets/icons/salir.png') }}" alt="Cerrar Sesión Icon" style="width: 24px; margin-right: 10px;">
                        Cerrar Sesión
                    </a>
                </div>
            </li>
            <a id="boton-mis-cursos" href="{{ route('Inicio') }}">
                <img src="{{ asset('assets/icons/cursos.png') }}" alt="Mis Cursos Icon" style="width: 24px; margin-right: 10px;">
                Mis Cursos
            </a>

            @if (auth()->user()->role == 'Docente')
                <a id="boton-asignar-cursos" href="{{ route('AsignarCurso') }}">
                    <img src="{{ asset('assets/icons/asignar.png') }}" alt="Asignar Cursos Icon" style="width: 24px; margin-right: 10px;">
                    Asignar Cursos
                </a>
            @endif

            <a id="boton-aportes-pagos" href="{{ route('pagos') }}">
                <img src="{{ asset('assets/icons/pago.png') }}" alt="Aportes/Pagos Icon" style="width: 24px; margin-right: 10px;">
                Aportes/Pagos
            </a>


            <!-- Botón desplegable -->
            <li class="dropdown">
                <a class="navbar-button dropdown-button" href="#">
                    <img src="{{ asset('assets/icons/like.png') }}" alt="Like Icon" style="width: 16px; margin-right: 10px;">
                    Siguenos &#9660;
                </a>
                <!-- Contenido del botón desplegable -->
                <div class="dropdown-content">
                    <a href="https://www.facebook.com/profile.php?id=100063510101095&mibextid=ZbWKwL">
                        <img src="{{ asset('assets/icons/fb.png') }}" alt="Facebook Icon" style="width: 24px; margin-right: 10px;">
                        FaceBook
                    </a>
                    <a href="https://www.tiktok.com/@educarparalavida?_t=8fbFcMbWOGo&_r=1">
                        <img src="{{ asset('assets/icons/tk.png') }}" alt="TikTok Icon" style="width: 24px; margin-right: 10px;">
                        TikTok
                    </a>
                    <a href="https://instagram.com/fundeducarparalavida?igshid=MzRlODBiNWFlZA==">
                        <img src="{{ asset('assets/icons/ig.png') }}" alt="Instagram Icon" style="width: 24px; margin-right: 10px;">
                        Instagram
                    </a>
                </div>
            </li>
            <!-- Botón desplegable -->
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="notificacionesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Notificaciones &#9660;
                </a>
                <!-- Contenido del botón desplegable -->
                <div  class="dropdown-content">
                    <a class="dropdown-item" href="#" onclick="mostrarNotificacion('¡Estudiante Juan inscrito exitosamente en el curso de Matemáticas!', '/lista-estudiantes/1', 'hace unos segundos')">Estudiante Juan inscrito en Matemáticas</a>
                    <!-- Puedes agregar más notificaciones aquí -->
                </div>
            </li>

        </ul>





    </nav>




    <script>
        // Función para mostrar las notificaciones
        document.getElementById("mostrarNotificaciones").addEventListener("click", function() {
            // Simulamos una notificación (puedes cambiar esto por la lógica real)
            var mensaje = "¡Estudiante inscrito exitosamente en el curso de Matemáticas!";
            var accion = "/lista-estudiantes/1"; // Cambia esto por la URL correcta
            var tiempo = "hace unos segundos";

            // Creamos un elemento para la notificación
            var notificacion = document.createElement("div");
            notificacion.className = "alert alert-info";
            notificacion.innerHTML = `<p>${mensaje} <a href="${accion}" class="alert-link">Ir a la lista de estudiantes</a>. (${tiempo})</p>`;

            // Agregamos la notificación al contenedor
            var contenedor = document.getElementById("navbarNav");
            contenedor.appendChild(notificacion);
        });
    </script>



</body>
</html>
