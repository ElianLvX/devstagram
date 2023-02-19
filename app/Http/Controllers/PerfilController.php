<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct() // para que solo puedan verlo usuarios
    {
        $this->middleware('auth');
    }

    public function index(User $user)
    {
        // Aqui se muestra el Fromulario
        return view('perfil.index');
    }

    public function store(Request $request)
    {
        // este es para verificar que no ponga un username existente
        $request->request->add(['username' => Str::slug($request->username)]);

        // * Notas: "not_in" sirve para poder negar algunos textos ingresados en el input
        // *        en este caso sirve para negar algunos nombres de usuario bastante util para evitar que alguien se ponga el nombre de "editar-perfil"
        // * Notas2: "in" sirve para poner cadenas de texto que estaran permitidas ingresar por ejemplo ==> "in: pedro86, julian99"  son nombres que afuerza
        // *          se tienen que ingresar no va a permitir otro dato

        // ? el validador "unique" este caso esta validando que no tome un usuario existente y que permita guardar el nombre que tiene el usuario actual
        // ?    es decir que va a permitir que el nombre que tiene actualmente un usuario se pueda guardar y que no aparesca usuario existente

        $this->validate($request, [
            'username' => ['required','unique:users,username,'.auth()->user()->id,'min:3','max:20','not_in:twitter,editar-perfil,editar'], // Siempre usar la forma de arreglo es mas recomendable
        ]);

        if($request->imagen) {
            // Si hay Imagen
            $imagen = $request->file('imagen');

            $nombreImagen = Str::uuid() . "." . $imagen->extension();
    
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000);
    
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        // Guardar Cambios
        $usuario = User::find(auth()->user()->id); // aqui solicitamos al modelo el id del usuario autenticado actualmente
        $usuario->username = $request->username; // el nombre del usuario actual va ser igual al request que le acabamos de mandar de cambio de nombre de usuario
        // Caso1.- guarda la imagen si es que se subio, Caso2.- Verifica si solo se edito el nombre del usuario conservando la imagen  Caso3.- puede ir vacio ese campo es decir no subir ninguna imagen
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save(); // Guardamos en la base de datos

        // Redireccionar al Usuario
        // retornamos al usuario a su muro con la ultima actualizacion de nuestra variable($usuario) que ahora guarda al nuevo nombre de usuario
        return redirect()->route('post.index', $usuario->username);
    }
}