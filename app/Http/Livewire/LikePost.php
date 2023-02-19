<?php

namespace App\Http\Livewire;

use Livewire\Component;

// * Nota: Lo que se esta haciendo aqui basicamente se le esta dando la tarea de los likes a LiveWire 

// ! Importante: al momento que se manda a llamar el componente en la vista se llaman todas las funciones no es necesario llamarlas manual

// ? Ventajas de usar componentes con LiveWire: 1.- Ya trae los prevent default, 2.- evitas el @csrf etc.

class LikePost extends Component
{
    public $post; // Al declarar la variable automaticamente se pasa a la vista en este caso "like-post.blade.php"
    public $isLiked; // esta variable sirve para que verificar si el usuario ya dio click y el corazon cambie de color
    public $likes; // es para cambiar reactivamente los likes de la pantalla

    public function mount($post) // el post lo cacha desde la vista cuando llamamos a la vista del componente
    {
        $this->isLiked = $post->checkLike(auth()->user()); // si retorna un false no a dado like
        $this->likes = $post->likes->count();
    }

    public function like()
    {
        // usamos el $this por que la variable esta inicializada en esta clase la retornamos desde el controlador "PostController" a la viasta "show" y de show la retornamos aqui
        if($this->post->checkLike( auth()->user() )) { // este if sirve para verificar si el usuario autenticado ya le dio like a la publicacion

            $this->post->likes()->where('post_id', $this->post->id)->delete(); // si ya le dio like y le pica elimina el registro
            $this->isLiked = false; // y aqui mandamos a actualizar la vista diciendo que no ha dado like
            $this->likes--; // para disminuir los likes hacerlo reactivo y mandamos a la vista una disminucion

        } else { // Aqui se crea el registro
            $this->post->likes()->create([
                'user_id' => auth()->user()->id
            ]);

            $this->isLiked = true; // ya le dio like
            $this->likes++;
        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}