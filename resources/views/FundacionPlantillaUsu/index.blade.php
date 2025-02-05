@extends('FundacionPlantillaUsu.layout')

@section('nav2')
    <nav id="header"
        class=" fixed w-full z-12  shadow header header-main header-expand-lg header-transparent header-light py-5 mb-10">



        <div class="header-container">
            <div class="header-brand logo-izquierdo">
                <img src="{{ asset('./resources/img/logof.png') }}" class="w-24 lg:w-32 xl:w-40 h-auto">
            </div>
            <div class="header-brand logo-derecho">
                <img src="{{ asset('./assets/img/Acceder.png') }}" class="w-20 lg:w-24 xl:w-32 h-auto">
            </div>
        </div>






            <!-- Contenedor del menú -->
            <nav class="bg-white shadow-md">
                <div class="container mx-auto px-4">
                    <!-- Menú para móviles (hamburguesa) -->
                    <div class="lg:hidden flex items-center justify-between py-3">
                        <a href="{{ route('Inicio') }}" class="text-blue-900 text-lg font-bold">Logo</a>
                        <button id="mobileMenuButton" class="text-gray-500 focus:outline-none">
                            <i class="fas fa-bars fa-lg"></i>
                        </button>
                    </div>

                    <!-- Menú principal -->
                    <div id="mainMenu" class="hidden lg:flex lg:items-center lg:justify-between">
                        <ul class="list-reset lg:flex flex-1 items-center px-4 md:px-0">
                            <li class="mr-6 my-2 md:my-0">
                                <a href="{{ route('Inicio') }}"
                                    class="block py-1 md:py-3 pl-1 align-middle text-blue-900 no-underline hover:text-gray-900 border-b-2 border-orange-600 hover:border-orange-600">
                                    <i class="fas fa-home fa-fw mr-3 text-blue-900"></i>
                                    <span class="pb-1 md:pb-0 text-sm atma">Inicio</span>
                                </a>
                            </li>
                            <li class="mr-6 my-2 md:my-0">
                                <a href="{{ route('calendario') }}"
                                    class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-900 border-b-2 border-white hover:border-pink-500">
                                    <i class="fas fa-calendar fa-fw mr-3"></i>
                                    <span class="pb-1 md:pb-0 atma">Calendario</span>
                                </a>
                            </li>
                            <li class="mr-6 my-2 md:my-0">
                                <a href="{{ route('notificaciones') }}"
                                    class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-900 border-b-2 border-white hover:border-purple-500">
                                    <i class="fa fa-bell fa-fw mr-3"></i>
                                    <span class="pb-1 md:pb-0 text-sm atma">Notificaciones</span>
                                </a>
                            </li>
                            @if (auth()->user()->hasRole('Docente'))
                                <li class="mr-6 my-2 md:my-0">
                                    <a href="{{ route('sumario') }}"
                                        class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-900 border-b-2 border-white hover:border-green-500">
                                        <i class="fas fa-chart-area fa-fw mr-3"></i>
                                        <span class="pb-1 md:pb-0 text-sm atma">Sumario</span>
                                    </a>
                                </li>
                            @endif
                            <li class="mr-6 my-2 md:my-0">
                                <a href="{{ route('pagos') }}"
                                    class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-900 border-b-2 border-white hover:border-red-500">
                                    <i class="fa fa-wallet fa-fw mr-3"></i>
                                    <span class="pb-1 md:pb-0 text-sm atma">Pagos</span>
                                </a>
                            </li>
                        </ul>

                        <!-- Menú de usuario (desplegable) -->
                        <div class="relative">
                            <button id="userMenuButton" class="flex items-center text-gray-500 focus:outline-none">
                                <i class="fas fa-user-circle fa-lg"></i>
                            </button>
                            <div id="userMenu"
                                class="bg-white rounded shadow-md mt-2 absolute right-0 min-w-[200px] overflow-auto z-30 invisible">
                                <ul class="list-reset">
                                    <li>
                                        <a href="{{ route('Miperfil') }}"
                                            class="px-4 py-2 block text-gray-900 hover:bg-gray-400 no-underline">
                                            Mi perfil
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="px-4 py-2 block text-gray-900 hover:bg-gray-400 no-underline">
                                            Notificaciones
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="border-t mx-2 border-gray-400">
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            class="px-4 py-2 block text-gray-900 hover:bg-gray-400 no-underline">
                                            Cerrar Sesión
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Script para manejar el menú móvil y el menú de usuario -->
            <script>
                // Menú móvil
                const mobileMenuButton = document.getElementById('mobileMenuButton');
                const mainMenu = document.getElementById('mainMenu');

                mobileMenuButton.addEventListener('click', () => {
                    mainMenu.classList.toggle('hidden');
                });

                // Menú de usuario
                const userMenuButton = document.getElementById('userMenuButton');
                const userMenu = document.getElementById('userMenu');

                userMenuButton.addEventListener('click', () => {
                    userMenu.classList.toggle('invisible');
                });
            </script>




        </div>

        </div>
    </nav>
@endsection

<!--Container-->
@section('container')
    <div class="container w-full mx-auto pt-20">
        <hr class="border-b-0 border-gray-400 my-4 mx-2">

        <div class="w-full px-4 md:px-0 md:mt-20 mb-16 text-gray-800 leading-normal">


            <h5 class="font-bold atma uppercase text-gray-600">@yield('title')</h5>



            <div class="flex flex-wrap">

                <!--Metric Card-->



                @yield('content')



                <!--/Metric Card-->
            </div>

        </div>



    </div>


    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{ session('success') }}",
                confirmButtonText: 'Entendido'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: "{{ session('error') }}",
                confirmButtonText: 'Reintentar'
            });
        @endif
    </script>
@endsection
<!--/container-->
