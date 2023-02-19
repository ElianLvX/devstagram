<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController extends Controller
{
    // Si no estan autenticados no pueden ver el home los mandara a login
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke() // este siempre se manda a llamar sin mencionarlo en la ruta es como un constructor(se llama inmediatamente)
    {
        // Obtener a quienes seguimos
        // accedemos al usuario autenticado, al modelo User con las instancia y alli accedemos al metodo de followers
        // despues le pedimos que con pluck nos muestre solo algunos datos y que los convierta en un array
        $ids = auth()->user()->followings->pluck('id')->toArray(); // hacemo uso de la relacion que esta en el modelo Users(Basicamente esta es la columna de followers_id) muestra los que estoi siguiendo
        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20); // este me trae todos los posts que tenga los usuarios que actualmente el usuario autenticado tiene

        return view('home', [
            'posts' => $posts,
        ]);
    }
}
