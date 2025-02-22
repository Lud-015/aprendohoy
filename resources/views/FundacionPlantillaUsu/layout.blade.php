<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inicio</title>
    <meta name="description" content="description here">
    <meta name="keywords" content="keywords,here">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('./resources/css/styles3.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js" integrity="sha256-XF29CBwU1MWLaGEnsELogU6Y6rcc5nCkhhx89nFMIDQ=" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atma:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=atma:600" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    @yield('nav2')
    @yield('container')



    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ $errors }}",
            });
        </script>
    @endif
    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 3000
        });
    </script>
@endif


    <footer class="bg-white shadow-md border-t border-gray-300">
        <div class="container mx-auto px-6 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center">

                <!-- Sección de Información -->
                <div class="text-center md:text-left mb-6 md:mb-0">
                    <h3 class="text-lg font-semibold text-gray-900">Fundación para Educar la Vida</h3>
                    <p class="text-gray-600 text-sm mt-2">
                        Inspirando el aprendizaje y el crecimiento personal.
                    </p>
                </div>

                <!-- Redes Sociales -->
                <div class="mb-6 md:mb-0">
                    <h3 class="font-semibold text-gray-900 text-center">Síguenos en:</h3>
                    <div class="flex justify-center space-x-4 mt-3">
                        <a href="https://www.facebook.com/profile.php?id=100063510101095&mibextid=ZbWKwL" target="_blank"
                            class="flex items-center text-gray-600 hover:text-blue-600 transition">
                            <img src="{{ asset('assets/icons/fb.png') }}" alt="Facebook" class="w-6 h-6">
                        </a>
                        <a href="https://www.tiktok.com/@educarparalavida?_t=8fbFcMbWOGo&_r=1" target="_blank"
                            class="flex items-center text-gray-600 hover:text-black transition">
                            <img src="{{ asset('assets/icons/tk.png') }}" alt="TikTok" class="w-6 h-6">
                        </a>
                        <a href="https://instagram.com/fundeducarparalavida?igshid=MzRlODBiNWFlZA==" target="_blank"
                            class="flex items-center text-gray-600 hover:text-pink-500 transition">
                            <img src="{{ asset('assets/icons/ig.png') }}" alt="Instagram" class="w-6 h-6">
                        </a>
                    </div>
                </div>

                <!-- Derechos de autor -->
                <div class="text-gray-600 text-sm text-center">
                    <script>
                        document.write("&copy; " + new Date().getFullYear() + " Fundación para Educar la Vida. Todos los derechos reservados.");
                    </script>
                </div>

            </div>
        </div>
    </footer>

    @include('botman.tinker')


</body>
<script>
    /*Toggle dropdown list*/
    /*https://gist.github.com/slavapas/593e8e50cf4cc16ac972afcbad4f70c8*/

    var userMenuDiv = document.getElementById("userMenu");
    var userMenu = document.getElementById("userButton");

    var navMenuDiv = document.getElementById("nav-content");
    var navMenu = document.getElementById("nav-toggle");

    document.onclick = check;

    function check(e) {
        var target = (e && e.target) || (event && event.srcElement);

        //User Menu
        if (!checkParent(target, userMenuDiv)) {
            // click NOT on the menu
            if (checkParent(target, userMenu)) {
                // click on the link
                if (userMenuDiv.classList.contains("invisible")) {
                    userMenuDiv.classList.remove("invisible");
                } else { userMenuDiv.classList.add("invisible"); }
            } else {
                // click both outside link and outside menu, hide menu
                userMenuDiv.classList.add("invisible");
            }
        }

        //Nav Menu
        if (!checkParent(target, navMenuDiv)) {
            // click NOT on the menu
            if (checkParent(target, navMenu)) {
                // click on the link
                if (navMenuDiv.classList.contains("hidden")) {
                    navMenuDiv.classList.remove("hidden");
                } else { navMenuDiv.classList.add("hidden"); }
            } else {
                // click both outside link and outside menu, hide menu
                navMenuDiv.classList.add("hidden");
            }
        }

    }

    function checkParent(t, elm) {
        while (t.parentNode) {
            if (t == elm) { return true; }
            t = t.parentNode;
        }
        return false;
    }
</script>
</html>
