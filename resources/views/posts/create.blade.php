@extends('layouts.app')

@section('titulo')
    Crea una nueva Publicación
@endsection
<!-- 
    Push sirve para mandar a llamar el stack('style') que creamos en la vista que hereda(vista padre)
    y ponemos el link dentro de ella para mandarlo a llamarlo estoi sirve para que no todas las vistas llamen al link
    debido a que solo una vista lo estara utilizando 
    esta hoja de estilos en este caso es de dropzone para poder subir imagenes
-->
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush

@section('contenido')
    <div class="md:flex md:items-center">
        <div class="md:w-1/2 px-10">
            <!-- Aqui se hace uso del atributo enctype que nos permita subir las imagenes -->
            <form action="{{ route('imagenes.store') }}" id="dropzone" method="POST" enctype="multipart/form-data"
                    class="dropzone border-dashed border-2 w-full h-96 rounded flex flex-col justify-center items-center font-semibold">
                @csrf

            </form>
        </div>

        <div class="md:w-1/2 p-10 bg-white rounded-lg shadow-2xl mt-10 md:mt-0 md:mx-2">
            <form action="{{ route('posts.store') }}" method="POST" novalidate><!-- Inicio de Formulario -->

                @csrf
                <div class="mb-5"> <!-- Bloque de formulario -->
                    <label for="titulo" class="mb-2 block uppercase text-gray-500 font-bold">
                        Titulo
                    </label>

                    <input 
                    id="titulo"
                    name="titulo"
                    type="text"
                    placeholder="Titulo de la Publicación"
                    class="border p-3 w-full rounded-lg @error('name')
                        border-red-500
                    @enderror"
                    value="{{ old('titulo') }}"
                    >
                    {{-- ! Aqui se tratan los errores al ingresar datos a los imputs --}}
                    @error('titulo')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 
                        text-center"> {{ $message }} </p>
                    @enderror
                </div>

                <div class="mb-5"> <!-- Bloque de formulario -->
                    <label for="descripcion" class="mb-2 block uppercase text-gray-500 font-bold">
                        Descripción
                    </label>

                    <textarea 
                        id="descripcion" 
                        name="descripcion" 
                        placeholder="Descripcion de la Publicación"
                        class="border p-3 w-full rounded-lg 
                        @error('name')
                            border-red-500
                        @enderror"
                        >{{ old('descripcion') }}</textarea>
                    {{-- ! Aqui se tratan los errores al ingresar datos a los imputs --}}
                    @error('descripcion')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 
                        text-center"> {{ $message }} </p>
                    @enderror
                </div>

                <!-- * Aqui se validara si se puso o na la imagen -->
                <div class="mb-5">
                    <input name="imagen" type="hidden" value="{{ old('imagen') }}" />
                    @error('imagen')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center"> {{ $message }} </p>
                    @enderror
                </div>

                <input 
                type="submit"
                value="Crear Publicación"
                class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase
                font-bold w-full p-3 text-white rounded-lg"
                >

            </form> <!-- Fin de Formulario -->
        </div>
    </div>
@endsection