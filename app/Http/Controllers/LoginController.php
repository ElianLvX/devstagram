<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    // Aqui se muestra la vista login
    public function index()
    {
        return view('auth.login');
    }

    // Aqui se resiven los datos ingresados en el login
    public function store(Request $request)
    {
        //dd('Autenticando..');
        //dd($request->remember); // depurando el input "Checkbox" para ver si fue habilitado el mismo

        // -*-*-*-*-*-*-* VALIDACION LOGIN -*-*-*-*-*-*-*-*-*-*-*
        $this->validate($request, [
            'email' => ['required','email'],
            'password' => ['required']
        ]);

        // -*-*-*-*-*-*-*VERIFICAR SI CREDENCIALES SON CORRECTAS-*-*-*-*-*-*-*-*-*-*-*
        if(!auth()->attempt($request->only('email','password'), $request->remember)){
            return back()->with('mensaje', 'Credenciales Incorrectas');
        }

        // Me mandara al "PostController" si las credenciales fueron correctas
        // es decir me manda al dashboard
        return redirect()->route('post.index', auth()->user()->username); 
    }
}
