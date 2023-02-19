<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    // Like es como una tabla pibote que guarda el ID del usuario que dio like y guarda el ID del Post donde dio ese like
    // ! Importante no estamo declarando la columna "post_id" por que tenemos una relacion en el modelo "Post" que es el modelo "likes"
    protected $fillable = [
        'user_id',
    ];
}
