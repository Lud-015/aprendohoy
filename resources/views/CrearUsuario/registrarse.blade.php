@section('titulo')
    Regístrate
@endsection



@section('content')


    <div class="container pt-lg-6 border-2">
        <div class="row justify-content-center">
            <div class="col-lg-8"> <!-- Aumenté el ancho de col-lg-5 a col-lg-8 -->
                <!-- Contenedor personalizado en lugar de un card -->
                <div class="bg-translucent-light shadow border-0 p-5 rounded"> <!-- Añadí padding y bordes redondeados -->
                    <!-- Título del formulario -->
                    <div class="text-center text-muted mb-4">
                        <h5 class="text-white">Regístrate</h5>
                    </div>

                    <!-- Mensajes de error -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Formulario de registro -->
                    <form action="{{ route('registrarse') }}" method="post">
                        @csrf
                        <!-- Campo de correo electrónico -->
                        <div class="form-group mb-4"> <!-- Aumenté el margen inferior -->
                            <label for="email" class="sr-only">Correo Electrónico</label>
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                </div>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Correo Electrónico" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <!-- Campos de contraseña y confirmación de contraseña -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group mb-4">
                                    <label for="password" class="sr-only">Contraseña</label>
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Contraseña" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" type="button"
                                                onclick="togglePasswordVisibility(this)">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group mb-4">
                                    <label for="password_confirmation" class="sr-only">Confirmar Contraseña</label>
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" placeholder="Confirmar Contraseña" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" type="button"
                                                onclick="togglePasswordVisibility(this)">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Campos de nombre y apellidos -->
                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group mb-4"> <!-- Aumenté el margen inferior -->
                                    <label for="country" class="sr-only">País</label>
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-world"></i></span>
                                        </div>
                                        <select class="form-control" id="country" name="country" required>
                                            <option value="">Selecciona tu país</option>
                                            <!-- Aquí puedes agregar opciones de países -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group mb-4"> <!-- Aumenté el margen inferior -->
                                    <label for="name" class="sr-only">Nombre</label>
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Nombre" value="{{ old('name') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-sm-6">
                                    <div class="form-group mb-4"> <!-- Aumenté el margen inferior -->
                                        <label for="lastname2" class="sr-only">Apellido Paterno</label>
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="lastname2" name="lastname2"
                                                placeholder="Apellido Paterno" value="{{ old('lastname2') }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4"> <!-- Aumenté el margen inferior -->
                                        <label for="lastname1" class="sr-only">Apellido Materno</label>
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="lastname1" name="lastname1"
                                                placeholder="Apellido Materno" value="{{ old('lastname1') }}" required>
                                        </div>
                                    </div>
                            </div>

                        </div>

                        <!-- Campo de apellido paterno y país -->

                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>

                        <!-- Botón de envío -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-facebook my-4">Registrarse</button>
                        </div>
                    </form>

                    <!-- Enlace para volver al inicio de sesión -->
                    <div class="text-center">
                        <p class="text-white">¿Ya tienes una cuenta? <a href="{{ route('login.signin') }}"
                                class="text-white">Inicia sesión aquí</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        function togglePasswordVisibility(button) {
            const inputGroup = button.closest('.input-group'); // Encuentra el contenedor padre más cercano
            const input = inputGroup.querySelector('input'); // Obtiene el campo de contraseña dentro del mismo grupo
            const icon = button.querySelector('i'); // Obtiene el ícono dentro del botón

            if (input.type === 'password') {
                input.type = 'text'; // Muestra la contraseña
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password'; // Oculta la contraseña
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

@endsection

@include('layoutlogin')

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
    // Array of countries
    const countries = [
        // América del Norte
        "Canada", "Estados Unidos", "México",

        // América Central y el Caribe
        "Belice", "Costa Rica", "Cuba", "El Salvador", "Guatemala", "Honduras", "Nicaragua", "Panamá",
        "República Dominicana",

        // América del Sur
        "Argentina", "Bolivia", "Brasil", "Chile", "Colombia", "Ecuador", "Guyana", "Paraguay", "Perú", "Surinam",
        "Uruguay", "Venezuela",

        // Europa
        "Alemania", "Francia", "España", "Italia", "Reino Unido", "Portugal", "Países Bajos", "Bélgica", "Suiza",
        "Austria", "Grecia", "Suecia", "Noruega",

        // Asia
        "China", "India", "Japón", "Corea del Sur", "Indonesia", "Filipinas", "Malasia", "Singapur", "Tailandia",
        "Vietnam", "Israel", "Turquía", "Arabia Saudita",

        // Oceanía
        "Australia", "Nueva Zelanda"
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
