<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/logoedin.png">
    <title>Iniciar Sesion</title>
    <!-- Fonts and icons -->
    <link rel="stylesheet" href="../assets/fonts/atma-gold.ttf">
    <link rel="stylesheet" href="../assets/fonts/alegreya-sans-black.ttf">
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="../assets/css/argon-design-system.css" rel="stylesheet" />
    <link href="../assets/css/log.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Estilos para la card con desenfoque */
        .card {
            position: relative;
            width: 300px;
            height: 400px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: blur(5px);
            /* Aplicar desenfoque */
            transition: filter 0.3s ease;
        }

        .card-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.8);
            /* Fondo semi-transparente */
            padding: 20px;
            text-align: center;
            border-radius: 10px;
        }

        .card:hover .card-img {
            filter: blur(0);
            /* Remover desenfoque al pasar el ratón */
        }
    </style>
</head>


<body class="login-page">

    <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light py-10">
        <div class="container">
            <div class="navbar-container">
                <div class="navbar-brand logo-izquierdo">
                    <img src="../assets/img/logof.png" style=" height: 65px;">
                </div>
                <a class="navbar-brand logo-derecho ml-auto">
                    <img src="../assets/img/Acceder.png" style=" height: 105px;">
                </a>
            </div>
        </div>
    </nav>



    <section class="section"
        style="background: linear-gradient(rgba(0, 0, 255, 0.3), rgba(0, 0, 255, 0.3)), url('{{ asset('assets/img/bg2.png') }}'); background-size: cover; background-repeat: no-repeat; filter: brightness(0.8) contrast(1.2);">
        <div class="container pt-lg-6">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card bg-translucent-light shadow border-0">
                        <div class="card-body px-lg-2 py-lg-2">
                            @if (auth()->check())
                            <div class="text-center text-muted mb-4">
                                <h5 class="text-white">Ya Iniciaste Sesión</h5>
                                <a class="btn btn-facebook" href="{{ route('Inicio') }}">
                                    Volver al inicio
                                </a>
                            </div>
                                @else
                                <div class="text-center text-muted mb-4">
                                    <h5 class="text-white">Iniciar Sesión</h5>
                                </div>
                                    <form role="form" method="post">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <div class="input-group input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                                </div>
                                                <input class="form-control" placeholder="Correo Electronico"
                                                    type="email" name="email">
                                            </div>
                                        </div>
                                        <div class="form-group focused">
                                            <div class="input-group input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="ni ni-lock-circle-open"></i></span>
                                                </div>
                                                <input class="form-control" placeholder="Contraseña" type="password"
                                                    name="password">
                                                <div class="input-group-append">
                                                    <button class="btn btn-secondary" type="button"
                                                        onclick="togglePasswordVisibility(this)">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-facebook my-4 ">Acceder</button>
                                        </div>
                                    </form>

                                    <a class="text-white" href="{{route('signin')}}">Crear una nueva cuenta</a>
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="footer">
        <div class="container">
            <div class="row row-grid align-items-center mb-5">
                <div class="col-lg-6">
                    <h3 class="text-primary font-weight-light mb-2">Gracias por la visita!</h3>
                </div>
            </div>
            <hr>
            <div class="row align-items-center justify-content-md-between">
                <div class="col-md-6">
                    <div class="copyright">
                        <script>
                            document.write("&copy; " + new Date().getFullYear() +
                                " <a href='' target='_blank'>Fundación para educar la vida</a>.");
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Core JS Files -->
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ $errors->first('email') }}",
                timer: 5000,
                showConfirmButton: false,
            });
        </script>
    @endif
    <script>
        function togglePasswordVisibility(button) {
            const passwordField = document.getElementById('password');
            const icon = button.querySelector('i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

    <script src="../assets/js/core/jquery.min.js" type="text/javascript"></script>
    <script src="../assets/js/core/popper.min.js" type="text/javascript"></script>
    <script src="../assets/js/core/bootstrap.min.js" type="text/javascript"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <script src="../assets/js/plugins/bootstrap-switch.js"></script>
    <script src="../assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
    <script src="../assets/js/plugins/moment.min.js"></script>
    <script src="../assets/js/plugins/datetimepicker.js" type="text/javascript"></script>
    <script src="../assets/js/plugins/bootstrap-datepicker.min.js"></script>
    <script>
        function togglePasswordVisibility(button) {
            var passwordInput = button.parentNode.previousElementSibling;
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                button.innerHTML = '<i class="fa fa-eye-slash"></i>';
            } else {
                passwordInput.type = "password";
                button.innerHTML = '<i class="fa fa-eye"></i>';
            }
        }
    </script>
</body>

</html>
