<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function __construct()
    {
        // este checa que el usuario este autenticado antes de entrar a cualquier funcion de este controlador ta prro
        // o puedes permitir que funciones o eventos mostrar con "->except(['show]), pueden ser uno o varios metodos en forma de arreglo
        $this->middleware('auth')->except(['show','index']); // si no estan logueados les permitira acceder a las funciones
    }

    // Aqui utilizamos el route model baining mandamos a llamar al modelo y pasamos los atributos del mismo
    // en la variable user y asi podemos acceder a los datos de la BD
    public function index(User $user) 
    {
        //dd(auth()->user()); // es practicamente resivido todos los datos ingresados en el formulario como el $request

        // le pido que me seleccione el "user_id" que sea igual al "$user->id" <- que es el que esta asociado al controlador postcontroller
        // con el route model baning al momento de nosotros entrar al dashboard con un usuario esa variable toma el id de nuestro actual usuario autenticado
        // y con el get() trae todos los datos que estan asociados a ese id ese caso los atributos de la tabla Post = 'titulo', 'Descripcion', 'Imagen'
        $posts = Post::where('user_id', $user->id)->latest()->paginate(20); // trae todos los post del usuario al que estemos visitando y paginate() en ves de get solo nos mostrara el numero de registros que le pasemos y los demas los va a paginar
        return view('dashboard', [ // ! dentro de este arreglo se estan pasando las variables a la vista es decir estas variables pueden ser consultadas en dashboard
            'user' => $user, // estan en formato de diccionario pero aun asi se acceden con el tipico -> {{ $user }}
            'posts' => $posts
        ]);
    }
    // la funcion create es la que nos permite visualizar el formulario
    // ose anos retorna la vista del formalio
    public function create()
    {
        //dd('Creando Post...');
        // -*-*-*-*-*-*-*-*-*-*-CREACION DE POSTS-*-*-*-*-*-*-*-*-*-*-**
        return view('posts.create');
    }
    // L funcion store es la que nos permite almacenar los datos en la base de datos y tambien valida los valores ingresados en el formulario
    // simpre va a tener el parametro de "Request" de parametro y tambien este validara y un poco mas
    public function store(Request $request)
    {
        //dd('Creando publicacion');
        //'hola' => 'required'|'max:10', otra forma de pedir validacion 
        $this->validate($request, [
            'titulo' => ['required', 'max:255'],
            'descripcion' => ['required'],
            'imagen' => ['required']
        ]);

        // Forma 1 de crear registros

        Post::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id
        ]);

        // Forma 2 de crear registros

        // $post = new Post;
        // $post->titulo = $request->titulo;
        // $post->descripcion = $request->descripcion;
        // $post->imagen = $request->imagen;
        // $post->user_id = auth()->user()->id;
        // $post->save();

        // Forma 3 de Crear registros ya con las relaciones creadas
        // $request->user()->posts()->create([
        //     'titulo' => $request->titulo,
        //     'descripcion' => $request->descripcion,
        //     'imagen' => $request->imagen,
        //     'user_id' => auth()->user()->id,
        // ]);
        return redirect()->route('post.index', auth()->user()->username);
    }

    public function show(User $user, Post $post) // pasamos el modelo User por que en la ruta llamamos al nombre del usuario actualmente atutenticado
    {
        return view('posts.show',[
            'post' => $post,
            'user' => $user
        ]);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        //Eliminar la imagen
        $imagen_path = public_path('uploads/' . $post->imagen); // donde esta ubicada la imagen

        // llamamos a la clase "File" con el metodo estatico "existdd"
        if(File::exists($imagen_path)) { // este nos va a decir que si existe ese path(ruta) ejecutara el codigo
            unlink($imagen_path); // esta es una funcion de php para eliminar
        }

        return redirect()->route('post.index', auth()->user()->username);
    }
}