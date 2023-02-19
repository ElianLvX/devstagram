<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    // el Fillable es la informacion que se llenara en 
    // la base de datos

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id',
    ];

    // relacion de Post a User
    // un Post Puede tener un usuario
    // con belongsTo "Un post pertenece a un usuario"
    public function user()
    {
        return $this->belongsTo(User::class)->select(['name', 'username']);
    }

    // Relacion de Post tiene multiples comentarios
    // uno a Muchos
    // comentarios seria la que une a la tabla "user" con "post"
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    // relacion uno a muchos "un post tiene muchos likes"
    public function likes()
    {
        return $this->hasMany(Like::class);
    } 

    // esta funcion verifica si un usuario ya le dio me gusta, para que evitemos registros duplicados
    // "likes" es la funcion de arriva pero no se llama como funcion solo se llama "Likes" para que nos traiga los datos que contiene
    // si lo llamaramos como funcion se ejecutari la relacion y eso no es correcto solo se necesitan los datos que contiene
    public function checkLike(User $user) 
    {
        return $this->likes->contains('user_id', $user->id);
    }
}