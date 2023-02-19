<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    // El modelo user tiene el nombre del usuario que estamos visitando
    // y el reques tiene el nombre del usuario que esta autenticado actualmente 
    public function store(User $user)
    {
        $user->followers()->attach( auth()->user()->id );

        return back();
    }

    public function destroy(User $user)
    {
        $user->followers()->detach( auth()->user()->id );

        return back();
    }
}
