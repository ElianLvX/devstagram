@extends('layouts.app')

@section('titulo')
    Pagina Principal
@endsection

@section('contenido')
    {{-- * Nota: esta vista tiene la variable $posts que es la instancia al modelo "Post"(tabla) --}}

    {{-- * Asi se pasa la varaible al componente esta variable se puede usar en la vista y de ls siguiente forma se esta pasando al componente --}}
    {{-- y esta tambien se le tiene que pasar al constructor del componente como parametro --}}
    <x-listar-post :posts="$posts" /> 
    {{-- <x-listar-post /> Cuando esta asi esta indicando que el componente no va aceptar slots
    <x-listar-post> <!-- Esto es un Eslot -->
        <x-slot:titulo>  <!-- Esto es un Eslot con nombre-->
            <header> Esto es un titulo </header>
        </x-slot:titulo>

        <h1> Mostrando post desde slot </h1>
    </x-listar-post> --}}

@endsection