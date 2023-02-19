@extends('layouts.app')

@section('titulo')
    Inicia Sesion en DevStagram
@endsection

@section('contenido')
    <div class="md:flex md:justify-center md:gap-10 md:items-center">
        <div class="md:w-6/12 p-5">
            <img src="{{ asset('img/login.jpg') }}" alt="Imagen Login User">
        </div>

        <div class="md:w-4/12 bg-white p-6 rounded-lg shadow-2xl">
            <form method="POST" action=" {{ route('login') }}" novalidate>
                @csrf

                {{-- ! Codigo para que muestra mensaje si las credenciales no son correctas --}}
                @if (session('mensaje'))
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center"> 
                        {{ session('mensaje') }} 
                    </p>
                @endif

                <div class="mb-5"> <!-- Bloque de formulario -->
                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">
                        Email
                    </label>

                    <input 
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Tu Email de Registro"
                    class="border p-3 w-full rounded-lg
                    @error('email')
                        border-red-500
                    @enderror"
                    value="{{ old('email') }}"
                    >
                    {{-- ! Aqui se tratan los errores al ingresar datos a los imputs --}}
                    @error('email')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 
                        text-center"> {{ $message }} </p>
                    @enderror
                </div>
                
                <div class="mb-5"> <!-- Bloque de formulario -->
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">
                        Password
                    </label>

                    <input 
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Tu Password de Registro"
                    class="border p-3 w-full rounded-lg
                    @error('password')
                        border-red-500
                    @enderror"
                    >
                    {{-- ! Aqui se tratan los errores al ingresar datos a los imputs --}}
                    @error('password')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 
                        text-center"> {{ $message }} </p>
                    @enderror
                </div>

                <div class="mb-5">
                    <input id="recuerdame" type="checkbox" name="remember">
                    <label for="recuerdame" class="text-gray-500 text-sm">
                        Mantener mi Sesión Abierta
                    </label>
                </div>

                <input 
                type="submit"
                value="Iniciar Sesion"
                class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase
                font-bold w-full p-3 text-white rounded-lg"
                >

            </form>
        </div>
    </div>
@endsection