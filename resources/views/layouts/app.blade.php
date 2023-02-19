<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @stack('styles') <!-- Reserva este espacio para un estilo que no se necesite en todas las vistaas y lo podemos llamar desde blade con "(@-push) sin el guion" -->
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>DevStagram - @yield('titulo')</title>
    <script src="{{ asset('js/app.js') }}" defer></script> {{-- ? El atributo defer le indica al navegador que no espere por JavaScript en lugar de eso que siga procesando el html --}}
    @livewireStyles  <!-- Agrega los estilos de LiveWire -->
</head>
<body class="bg-gray-100">
<!-- Cabeza de pagina que hereda  -->
    <header class="p-5 border-b bg-white shadow">
        <div class="container mx-auto flex justify-between">
            <a href=" {{ route('home') }}" class="text-3xl font-black">
                DevStagram
            </a>

            {{-- ! Forma 1 saber si el usuario esta autenticado con "if" --}}
                {{-- @if (auth()->user())
                    <p>Autenticado</p>
                @else
                    <p>No autenticado</p>
                @endif --}}
            {{-- ! Forma 2 saber si el usuario esta autenticado con "auth" --}}
            @auth
                <!-- Si usuario Autenticado mostrar este menu -->
                <nav class="flex gap-2 items-center">

                    <a href=" {{ route('posts.create') }}" class="flex items-center gap-2 bg-white border p-2 text-gray-600 rounded text-sm
                        uppercase font-bold cursor-pointer">
                        <!-- -*--*-*-*-*-*-*-*-*-*-*-*-* ICONO BOTON -*-*-*-*-*-*-*-**-*-*-*-*-*-* -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                        </svg>
                        <!-- -*--*-*-*-*-*-*-*-*-*-*-*-* ICONO BOTON -*-*-*-*-*-*-*-**-*-*-*-*-*-* -->
                        Crear
                    </a>

                    <a class="font-bold text-gray-600 text-sm" href=" {{ route('post.index', auth()->user()->username) }}">
                        Hola:
                        <span class="font-normal">
                            {{ auth()->user()->username }}
                        </span>
                    </a>
                    <!-- Bloque de codigo para cerrar sesion -->
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="font-bold uppercase text-gray-600 text-sm">
                            Cerrar Sesión
                        </button>
                    </form>
                </nav>
            @endauth

            @guest
                <!-- Si usuario No Autenticado mostrar este menu -->
                <nav class="flex gap-2 items-center">
                    <a class="font-bold uppercase text-gray-600 text-sm" href="{{ route('login') }}">Login</a>
                    <a class="font-bold uppercase text-gray-600 text-sm" href="{{ route('register') }}">Crear Cuenta</a>
                </nav>
            @endguest

        </div>
    </header>

    <main class="container mx-auto mt-10">
        <h2 class=" font-black text-center text-3xl mb-10">
            @yield('titulo')
        </h2>
        @yield('contenido') <!-- aqui contenera el contenido de nuestras vistas -->
    </main>

    <footer class="mt-10 text-center p-5 text-gray-500 font-bold uppercase">
        DevStagram - Todos los derechos reservados
        {{ now()->year }}
    </footer>

        @livewireScripts <!-- carga los scripts de livewire para las peticiones de Ajax -->
</body>
</html>