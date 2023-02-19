<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    // se importa el modelo "User" para que no nos marque error solo para eso por que no se utiliza
    // * Notas: estamos agarrando los valores de la URL al menos el id por que el nombre del usuarios no nos sirve
    // *        debido a que si entramos logueados como ("usuariA") al post de ("usuarioB") si tomamos la URL no tomario el nombre de ("usuarioB") no el de 
    // *        ("usuarioA") que es el que esta comentando por eso no usamos el Username de la URL
    public function store(Request $request, User $user, Post $post)
    {
        // Validacion
        $this->validate($request, [
            'comentario' => ['required','max:255']
        ]);

        // almacenar resultados
        Comentario::create([
            'user_id' => auth()->user()->id, // aqui el valor es el id del usuario que esta autenticando actualmente
            'post_id' => $post->id, // se esta tomando del modelo nos pasa el id de la publicacion en que nos encontremos
            'comentario' => $request->comentario,
        ]);

        // Imprimir un Mensaje
        return back()->with('mensaje', "Comentario Agregado Correctamente!");
    }
}
