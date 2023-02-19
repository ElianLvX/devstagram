@extends('layouts.app')

@section('titulo')
    Perfil: {{ $user->username }}
@endsection

@section('contenido')

    <div class="flex justify-center">
        <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row">
            {{-- Llamado de imagen localizada en la carpeta public --}}
            <div class="w-8/12 lg:w-6/12 px-5 box-decoration-clone"> 
                {{-- ? ""Se utiliza el operador ternario para verificar si tiene una imagen si no se muestra el icono svg por defecto --}}
                <!-- La clase "rounded-full" sirve para redondear la imagen solo para presentarla no se guarda asi en la base de datos-->
                <img src=" {{ $user->imagen ? asset('perfiles') . '/' . $user->imagen :
                    asset('img/usuario.svg') }}" 
                    alt="Imagen Usuario"
                    class=" rounded-full"
                />
            </div>
            {{-- {{ dd($user) }} --}}
            {{--
                Nota: ahora para mostrar el username hacemos uso de la variable($user) que esta vinculada al modelo "User" 
                Asi que podemos acceder a todos los atributos de nuestra base de datos
            --}}
            {{-- Mostrar el usuario que actualmente creo la cuenta o inicio sesion --}}
            <div class="md:w-8/12 lg:w-6/12 px-5 flex flex-col items-center md:justify-center md:items-start py-10 md:py-10">

                <div class="flex items-center gap-2">
                    <p class="text-gray-700 text-2xl font-bold"> {{ $user->username }}</p>
                        @auth
                            @if ($user->id === auth()->user()->id) <!-- Para verificar si el usuario que quiere editar su cuenta es el mismo que esta visitando el perfil -->
                                <a href=" {{ route('perfil.index')}}" class="text-gray-500 hover:text-gray-800 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                    </svg>
                                </a>
                            @endif
                        @endauth
                </div>

                <p class="text-gray-800 text-sm mb-3 font-bold mt-5">
                    {{ $user->followers->count()}}
                    <span class="font-normal">
                        @choice('Seguidor|Seguidores', $user->followers->count())
                    </span>
                </p>

                <p class="text-gray-800 text-sm mb-3 font-bold"> 
                    {{ $user->followings->count()}}
                    <span class="font-normal">
                        Siguiendo
                    </span>
                </p>

                <p class="text-gray-800 text-sm mb-3 font-bold">
                    {{ $posts->count()}}
                    <span class="font-normal">
                        Posts
                    </span>
                </p>

                @auth
                    <!-- Si el perfil del usuario que se esta viendo es igual que el usuario autenticado no mostrar boton seguir y no seguir -->
                    @if($user->id !== auth()->user()->id) <!-- Esto es para evitar que el mismo usuario se siga a si mismo -->
                        
                        @if (!$user->siguiendo( auth()->user() ))
                            {{-- ! En este caso estamos pasando al usuario al que estamos visitando no el que esta autenticado --}}
                            <form 
                                action="{{ route('users.follow', $user) }}" 
                                method="POST"
                            >
                            @csrf
                            <input 
                                type="submit" 
                                class="bg-blue-600 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold cursor-pointer"
                                value="Seguir"
                            />
                            </form>
                        @else

                            <!-- Dejar de Seguir -->
                            <form 
                                action=" {{ route('users.unfollow', $user) }}"
                                method="POST"
                            >
                                @csrf
                                @method('DELETE')
                                <input 
                                    type="submit" 
                                    class="bg-red-600 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold cursor-pointer"
                                    value="Dejar de Seguir"
                                />
                            </form>
                        @endif

                    @endif 

                @endauth

            </div>

        </div>
    </div>

    {{-- {{ dd($posts) }} aqui accedemos a la variable creada en PostController para traer los posts que el usuario iso --}}

    {{-- * Notas: La variable $posts se definio en el "PostController" esa variable ya trae la consulta a la base de datos de los post del actual usuario autenticado --}}
    {{-- * Notas: podemos acceder a los atributos de la BD con la flecha "->"  Ejemplo:  $post->titulo, $user->username  --}}

    <section class="container mx-auto mt-10">
        <h2 class="text-4xl text-center font-black my-10">Publicaciones</h2>
        {{-- Aqui estoi llamando al componente y pasando la variable "$posts" que el controlador le da a la vista --}}
        <x-listar-post :posts="$posts" /> 
    </section>

@endsection