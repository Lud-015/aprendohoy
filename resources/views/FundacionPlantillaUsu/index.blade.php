@extends('FundacionPlantillaUsu.layout')

@section('nav2')
    <!-- Navigation -->
    <nav class="fixed w-full bg-white shadow-lg z-50">
        <div class="relative bg-[#1E4C92] h-24">
            <!-- Diagonal white overlay -->
            <div class="absolute top-0 right-0 w-[40%] h-full bg-white transform origin-top-right -skew-x-[24deg]"></div>

            <!-- Content container -->
            <div class="relative flex justify-between items-center h-full px-4 max-w-7xl mx-auto">
                <!-- Left logo - Fundación -->
                <div class="flex-shrink-0 z-10">
                    <img src="{{ asset('./resources/img/logof.png') }}" class="w-32 lg:w-40 xl:w-48 h-auto"
                        alt="Fundación Educar para la Vida">
                </div>
                <!-- Right logo - Aprendo Hoy -->
                <div class="flex-shrink-0 z-10">
                    <img src="{{ asset('./assets/img/Acceder.png') }}" class="w-28 lg:w-32 xl:w-36 h-auto" alt="Aprendo Hoy">
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4">


            <!-- Main navigation container -->
            <div class="border-t border-gray-100">
                <div class="flex justify-between">
                    <!-- Mobile menu button -->
                    <div class="lg:hidden flex items-center">
                        <button id="mobileMenuButton" class="text-gray-500 hover:text-gray-700 focus:outline-none p-2">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>

                    <!-- Desktop menu -->
                    <div id="mainMenu" class="hidden lg:flex lg:flex-1">
                        <div class="flex space-x-6">
                            <a href="{{ route('Inicio') }}"
                                class="group flex items-center px-3 py-4 text-sm font-medium text-gray-700 hover:text-blue-600 relative">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span>Inicio</span>
                                <div
                                    class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 scale-x-0 group-hover:scale-x-100 transition-transform">
                                </div>
                            </a>

                            <a href="{{ route('calendario') }}"
                                class="group flex items-center px-3 py-4 text-sm font-medium text-gray-700 hover:text-blue-600 relative">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Calendario</span>
                                <div
                                    class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 scale-x-0 group-hover:scale-x-100 transition-transform">
                                </div>
                            </a>

                            <div x-data="{ open: false }" class="relative">
                                <!-- Botón de notificaciones -->
                                <button @click="open = !open"
                                    class="flex items-center px-3 py-4 text-sm font-medium text-gray-700 hover:text-blue-600 relative">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    <span>Notificaciones</span>
                                    <div class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 scale-x-0 group-hover:scale-x-100 transition-transform"></div>
                                </button>

                                <!-- Dropdown de notificaciones -->
                                <div x-show="open" @click.away="open = false"
                                    class="absolute right-0 mt-2 w-64 bg-white border rounded-lg shadow-lg overflow-hidden">
                                    <ul class="divide-y divide-gray-200">
                                        @forelse (auth()->user()->notifications()->latest()->take(4)->get() as $notification)
                                            <li class="p-3 text-sm text-gray-700 hover:bg-gray-100">
                                                <p>{{ $notification->data['message'] }}</p>
                                                <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                            </li>
                                        @empty
                                            <li class="p-3 text-sm text-gray-500 text-center">No hay notificaciones</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>


                            @if (auth()->user()->hasRole('Docente'))
                                <a href="{{ route('sumario') }}"
                                    class="group flex items-center px-3 py-4 text-sm font-medium text-gray-700 hover:text-blue-600 relative">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    <span>Sumario</span>
                                    <div
                                        class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 scale-x-0 group-hover:scale-x-100 transition-transform">
                                    </div>
                                </a>
                            @endif

                            <a href="{{ route('pagos') }}"
                                class="group flex items-center px-3 py-4 text-sm font-medium text-gray-700 hover:text-blue-600 relative">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                <span>Pagos</span>
                                <div
                                    class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 scale-x-0 group-hover:scale-x-100 transition-transform">
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- User menu - Desktop -->
                    <div class="relative my-3  hidden lg:block">
                        <button id="userMenuButton"
                            class="flex items-center text-gray-700 hover:text-blue-600 focus:outline-none">
                            <p>{{ auth()->user()->name }} {{ auth()->user()->lastname1 }} {{ auth()->user()->lastname2 }}
                            </p>
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>

                        <!-- User menu dropdown - Desktop -->
                        <div id="userMenu"
                            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5">
                            <a href="{{ route('Miperfil') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mi perfil</a>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Notificaciones</a>
                            <div class="border-t border-gray-100"></div>
                            <a href="{{ route('logout') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Cerrar Sesión</a>
                        </div>
                    </div>

                    <!-- User menu button - Mobile -->
                    <div class="lg:hidden flex items-center">
                        <button id="mobileUserMenuButton"
                            class="flex items-center text-gray-700 hover:text-blue-600 focus:outline-none p-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div id="mobileMenu" class="hidden lg:hidden">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('Inicio') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Inicio</a>
                    <a href="{{ route('calendario') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Calendario</a>
                    <a href="{{ route('notificaciones') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Notificaciones</a>
                    @if (auth()->user()->hasRole('Docente'))
                        <a href="{{ route('sumario') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Sumario</a>
                    @endif
                    <a href="{{ route('pagos') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Pagos</a>

                    <!-- User menu items - Mobile -->
                    <div class="border-t border-gray-200 mt-4 pt-4">
                        <a href="{{ route('Miperfil') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Mi
                            Perfil</a>
                        <a href="#"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Notificaciones</a>
                        <a href="{{ route('logout') }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-red-600 hover:text-red-700 hover:bg-gray-50">Cerrar
                            Sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileUserMenuButton = document.getElementById('mobileUserMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');
        const mainMenu = document.getElementById('mainMenu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        mobileUserMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Desktop user menu toggle
        const userMenuButton = document.getElementById('userMenuButton');
        const userMenu = document.getElementById('userMenu');

        userMenuButton.addEventListener('click', () => {
            userMenu.classList.toggle('hidden');
        });

        // Close menus when clicking outside
        document.addEventListener('click', (event) => {
            if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }

            if (!mobileMenuButton.contains(event.target) &&
                !mobileUserMenuButton.contains(event.target) &&
                !mobileMenu.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    </script>
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
