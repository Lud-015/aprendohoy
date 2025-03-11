@section('titulo')
    Regístrate
@endsection



@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="bg-gray-transparent shadow border-0 p-5 rounded">
                <!-- Título del formulario -->
                <div class="text-center mb-4">
                    <h5 style="color: white">Regístrate</h5>
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
                    <div class="mb-3">
                        <label for="email" class="form-label text-white">Correo Electrónico</label>
                        <div class="input-group">
                            <span class="input-group-text rounded-start-pill"><i class="fa fa-envelope"></i></span>
                            <input type="email" class="form-control rounded-end-pill" id="email" name="email"
                                   placeholder="Correo Electrónico" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <!-- Campos de contraseña y confirmación -->
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label for="password" class="form-label text-white">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text rounded-start-pill"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="Contraseña" required>
                                <button class="btn btn-secondary rounded-end-pill toggle-password" type="button"
                                        data-target="password">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="password_confirmation" class="form-label text-white">Confirmar Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text rounded-start-pill"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control" id="password_confirmation"
                                       name="password_confirmation" placeholder="Confirmar Contraseña" required>
                                <button class="btn btn-secondary rounded-end-pill toggle-password" type="button"
                                        data-target="password_confirmation">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Campo de país -->
                    <div class="mb-3">
                        <label for="country" class="form-label text-white">País</label>
                        <div class="input-group">
                            <span class="input-group-text rounded-start-pill"><i class="fa fa-globe"></i></span>
                            <select class="form-control rounded-end-pill" id="country" name="country" required>
                                <option value="">Selecciona tu país</option>
                            </select>
                        </div>
                    </div>

                    <!-- Campos de nombre y apellidos -->
                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <label for="name" class="form-label text-white">Nombre</label>
                            <div class="input-group">
                                <span class="input-group-text rounded-start-pill"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control rounded-end-pill" id="name" name="name"
                                       placeholder="Nombre" value="{{ old('name') }}" required>
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label for="lastname1" class="form-label text-white">Apellido Paterno</label>
                            <div class="input-group">
                                <span class="input-group-text rounded-start-pill"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control rounded-end-pill" id="lastname1" name="lastname1"
                                       placeholder="Apellido Paterno" value="{{ old('lastname1') }}" required>
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label for="lastname2" class="form-label text-white">Apellido Materno</label>
                            <div class="input-group">
                                <span class="input-group-text rounded-start-pill"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control rounded-end-pill" id="lastname2" name="lastname2"
                                       placeholder="Apellido Materno" value="{{ old('lastname2') }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- reCAPTCHA -->
                    <div class="g-recaptcha mb-3" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>

                    <!-- Botón de envío -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill">Registrarse</button>
                    </div>
                </form>

                <!-- Enlace para volver al inicio de sesión -->
                <div class="text-center mt-3">
                    <p class="text-white">¿Ya tienes una cuenta? <a href="{{ route('login.signin') }}" class="text-white">Inicia sesión aquí</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Seleccionar todos los botones con la clase toggle-password
        const toggleButtons = document.querySelectorAll('.toggle-password');

        // Agregar event listener a cada botón
        toggleButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                // Obtener el ID del campo de contraseña desde el atributo data-target
                const targetId = this.getAttribute('data-target');
                const passwordField = document.getElementById(targetId);

                // Cambiar el tipo de input
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    this.querySelector('i').classList.remove('fa-eye');
                    this.querySelector('i').classList.add('fa-eye-slash');
                } else {
                    passwordField.type = 'password';
                    this.querySelector('i').classList.remove('fa-eye-slash');
                    this.querySelector('i').classList.add('fa-eye');
                }
            });
        });
    });
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
