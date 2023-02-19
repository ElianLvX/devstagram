<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index() 
    {
        return view('auth.register');
    }

    public function store(Request $request) 
    {
        // dd($request);
        // dd($request->get('username')); //  para buscar algun atributo espesifico

        // -*-*-*-*-*-*-EDITAR EL REQUEST-*-*-*-*-*-*-*-*-*
        // Nota: Interceptamos el request y le quitamos los espacios y acentos con el "Str::slug()" y asi
        // despues podemos pasar las validaciones siguientes  
        $request->request->add(['username' => Str::slug($request->username)]);

        // -*-*-*-*-*-*-VALIDACION-*-*-*-*-*-*-*-*-*
        $this->validate($request, [
            // Forma 1
            // si se exede de tres reglas de validacion usar la Forma 2 los arreglos
            // 'name' => 'required|min:5',

            // Forma 2
            'name' => ['required', 'max:30'],
            'username' => ['required','unique:users','min:3','max:20'],
            'email' => ['required','unique:users','email', 'max:60'],
            'password' => ['required','confirmed'],
        ]);
        
        // -*-*-*-*-*-*-INSERTAR DATOS CON EL MODELO USER-*-*-*-*-*-*-*-*-*
        // ? Lo siguiente es equivalente a un insert Into en mysql
        // Helper: Str::lower() "Convierte todo a minuscula"
        // Helper: Str:slug() "Lo convierte en una URL" y "Elimina los espacios y los sustituye por '-' y quita los acentos"
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make( $request->password)
        ]);

        // -*-*-*-*-*AUTENTICACION-*-*-*-*-*-*-*-*
        // Forma 1 Autenticar
            // auth()->attempt([
            //     'email' => $request->email,
            //     'password' => $request->password,
            // ]);
        // Forma 2 de autenticar
        auth()->attempt($request->only('email','password'));

        // -*-*-*-*-*-*REDIRECCIONAR*-*-*-*-*-*-*
        //return redirect()->route('post.index');
        return redirect()->route('post.index', auth()->user()->username);
    }
}
