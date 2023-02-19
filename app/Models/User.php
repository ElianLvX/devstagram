<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [ 
        // mo se agrego el atribuyo imagen debido a que no es ciertamente necesario pero no pasa nada si se agrega o no 
        // por que si llenamos un factory pues no es necesario probar si esta llegando bien la imagen o no
        'name',
        'email',
        'password',
        'username',
        'imagen'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Aqui se asigna la relacion de usuarios a el modelo Post
    // un usuario puede tener muchos posts (hasmany) o "one to many"
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Un usuario puede tener muchos likes one tu many
    // aqui se relaciona la tablad de usuario con la de likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Almacena los seguidores de un usuario
    // El metodo followers en la tabla de followers pertenece a muchos usuarios
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    // Almacena los que seguimos
    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    // Comprobar si un usuario ya sigue a otro
    // ! No es ninguna relacion el metodo "siguiendo"
    // va a buscar en la tabla followers y va a iterar los registros buscando el id del usuario
    public function siguiendo(User $user)
    {
        return $this->followers->contains( $user->id );
    }
}
