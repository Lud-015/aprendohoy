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
        <div class="w-full container mx-auto flex flex-wrap items-right mt-0 pt-3 mb-12 pb-20 md:pb-1">



            <div class=" lg:hidden ml-10">
                <button id="nav-toggle"
                    class="flex items-center px-3 py-2 border rounded text-blue-500 border-blue-200 hover:text-gray-900 hover:border-teal-500 appearance-none focus:outline-none">
                    <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <title>Menu</title>
                        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                    </svg>
                </button>
            </div>



            <div class="w-full lg:flex lg:items-center  bg-white z-10" id="nav-content">
                <div class="flex relative pull-right pl-2 pr-2 md:pr-0 ">

                    <div class="list-reset lg:flex flex-1 items-center px-4 mr-6 my-2 md:my-0 ">
                        <button id="userButton" class="flex items-center focus:outline-none mr-3">
                            @if (auth()->user()->avatar == '')
                                <img class="w-8 h-8 rounded-full mr-4" src="{{ asset('./assets/img/user.png') }}"
                                    alt="Avatar of User">
                            @else
                                <img class="w-8 h-8 rounded-full mr-4"
                                    src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar of User">
                            @endif
                            <span class="hidden md:inline-block atma">Bienvenid@, {{ auth()->user()->name }}
                                {{ auth()->user()->lastname1 }} </span>
                            <svg class="pl-2 h-2" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129"
                                xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129">
                                <g>
                                    <path
                                        d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z" />
                                </g>
                            </svg>
                        </button>
                        <div id="userMenu"
                            class="bg-white rounded shadow-md mt-2 absolute mt-12 top-0 right-0 min-w-full overflow-auto z-30 invisible">
                            <ul class="list-reset">
                                <li><a href="{{ route('Miperfil') }}"
                                        class="px-4 py-2 block text-gray-900 hover:bg-gray-400 no-underline hover:no-underline">Mi
                                        perfil</a></li>
                                <li><a href="#"
                                        class="px-4 py-2 block text-gray-900 hover:bg-gray-400 no-underline hover:no-underline">Notificaciones</a>
                                </li>
                                <li>
                                    <hr class="border-t mx-2 border-gray-400">
                                </li>
                                <li><a href="{{ route('logout') }}"
                                        class="px-4 py-2 block text-gray-900 hover:bg-gray-400 no-underline hover:no-underline">Cerrar
                                        Sesion</a>
                                </li>
                            </ul>
                        </div>
                    </div>



                </div>

                <ul class="list-reset lg:flex flex-1 items-center px-4 md:px-0 ">
                    <li class="mr-6 my-2 md:my-0">
                        <a href="{{ route('Inicio') }}"
                            class="block py-1 md:py-3 pl-1 align-middle text-blue-900 no-underline hover:text-gray-900 border-b-2 border-orange-600 hover:border-orange-600">
                            <i class="fas fa-home fa-fw mr-3 text-blue-900"></i><span
                                class="pb-1 md:pb-0 text-sm atma">Inicio</span>
                        </a>
                    </li>
                    <li class="mr-6 my-2 md:my-0">
                        <a href="{{ route('calendario') }}"
                            class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-900 border-b-2 border-white hover:border-pink-500">
                            <i class="fas fa-calendar fa-fw mr-3"></i><span class="pb-1 md:pb-0 atma">Calendario</span>
                        </a>
                    </li>
                    <li class="mr-6 my-2 md:my-0">
                        <a href="{{ route('notificaciones') }}"
                            class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-900 border-b-2 border-white hover:border-purple-500">
                            <i class="fa fa-bell fa-fw mr-3"></i><span
                                class="pb-1 md:pb-0 text-sm atma">Notificaciones</span>
                        </a>
                    </li>
                    @if (auth()->user()->hasRole('Docente'))

                    <li class="mr-6 my-2 md:my-0">
                        <a href="{{ route('sumario') }}"
                            class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-900 border-b-2 border-white hover:border-green-500">
                            <i class="fas fa-chart-area fa-fw mr-3"></i><span
                                class="pb-1 md:pb-0 text-sm atma">Sumario</span>
                        </a>
                    </li>
                    @endif

                    <li class="mr-6 my-2 md:my-0">
                        <a href="{{ route('pagos') }}"
                            class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-900 border-b-2 border-white hover:border-red-500">
                            <i class="fa fa-wallet fa-fw mr-3"></i><span class="pb-1 md:pb-0 text-sm atma">Pagos</span>
                        </a>
                    </li>
                </ul>


                <div class="relative pull-right pl-3 pr-5 md:pr-0">

                    <input type="search" placeholder="Search"
                        class=" bg-gray-100 text-sm mr-4 text-gray-800 transition border focus:outline-none focus:border-gray-700 rounded py-1 px-2 pl-10 appearance-none leading-normal">
                    <div class="absolute search-icon" style="top: 0.375rem;left: 1.75rem;">
                        <svg class="fill-current pointer-events-none text-gray-800 w-4 h-4"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path
                                d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z">
                            </path>
                        </svg>
                    </div>
                </div>

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
