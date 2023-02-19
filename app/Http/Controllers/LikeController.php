<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request, Post $post) 
    {
        $post->likes()->create([
            'user_id' => $request->user()->id
        ]);

        return back();
    }
    
    public function destroy(Request $request, Post $post)
    {
        // ? Explicacion de "where('post_id', $post->id)" => "quiero que elimines de la tabla likes en la columna 'post_id' que sea igual a $post->id(que es el id de la publicacion que estamo visitando)
        $request->user()->likes()->where('post_id', $post->id)->delete();// ==> delete from likes where id="4";d

        return back(); // lo regresa a la misma pagianvvd
    }
}
