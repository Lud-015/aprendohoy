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
        <div class="container bg-translucent-neutral col-4">
            <div class="row">
                <div class="m-2 col-md-offset-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title text-black">Registrate</h2>
                        </div>
                        <div class="panel-body">
                            <form action="{{route('registrarse')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="email" class="control-label"><i aria-hidden="true" class="fa fa-envelope"></i> Correo Electrónico</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Correo Electrónico" required>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="password" class="control-label"><i aria-hidden="true" class="fa fa-lock"></i> Contraseña</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                                            <span class="toggle-password" onclick="togglePassword('password')"><i class="fa fa-eye"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="password_confirmation" class="control-label"><i aria-hidden="true" class="fa fa-lock"></i> Confirmar Contraseña</label>
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirmar Contraseña" required>
                                            <span class="toggle-password" onclick="togglePassword('password_confirmation')"><i class="fa fa-eye"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name" class="control-label"><i aria-hidden="true" class="fa fa-user"></i> Nombre</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="lastname1" class="control-label"><i aria-hidden="true" class="fa fa-user"></i> Apellido Materno</label>
                                            <input type="text" class="form-control" id="lastname1" name="lastname1" placeholder="Apellido Materno" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="lastname2" class="control-label"><i aria-hidden="true" class="fa fa-user"></i> Apellido Paterno</label>
                                            <input typetext" class="form-control" id="lastname2" name="lastname2" placeholder="Apellido Paterno" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="country" class="control-label">Selecciona tu país</label>
                                            <select class="form-control" id="country" name="country">
                                                <option value="">Selecciona tu país</option>
                                                <!-- Add country options here -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
                            </form>
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

    <script>
        // Array of countries
        const countries = [
            "Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Argentina", "Australia",
            "Austria", "Brazil", "Bolivia","Canada", "Chile", "China", "Colombia", "Costa Rica", "Cuba",
            "Denmark", "Ecuador", "Egypt", "El Salvador", "España", "Estados Unidos",
            "Francia", "Alemania", "Grecia", "Guatemala", "Honduras", "India", "Indonesia",
            "Irán", "Irak", "Irlanda", "Italia", "Japón", "México", "Nicaragua", "Panamá",
            "Paraguay", "Perú", "Polonia", "Portugal", "Reino Unido", "Rusia", "Suecia",
            "Suiza", "Turquía", "Ucrania", "Uruguay", "Venezuela"
        ];

        // Function to populate select dropdown
        function populateCountries(selectElement) {
            // Clear existing options except the first (default)
            while (selectElement.options.length > 1) {
                selectElement.remove(1);
            }

            // Sort countries alphabetically
            countries.sort();

            // Add countries to dropdown
            countries.forEach(country => {
                const option = new Option(country, country);
                selectElement.add(option);
            });
        }

        // Event listener to populate dropdown when page loads
        document.addEventListener('DOMContentLoaded', () => {
            const countrySelect = document.querySelector('select');
            if (countrySelect) {
                populateCountries(countrySelect);
            }
        });
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
        function togglePassword(id) {
            var input = document.getElementById(id);
            var icon = input.nextElementSibling.querySelector('i');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
        </script>
</body>

</html>
