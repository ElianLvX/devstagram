<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;

Route::get('/', HomeController::class)->name('home');
// * Notas: El orden de las rutas es muy importante por recomendacion en las rutas que llevan una variable en la url 
// *        es mas recomendable ponerlas mas abajo

// -*-*-*-*-*-*-*-*-*-*-* EDITAR PERFIL -*-*-*-*-*-*-*-*-*-*-*--*-*-*
Route::get('/editar-perfil', [PerfilController::class, 'index'])->name('perfil.index');
Route::post('/editar-perfil', [PerfilController::class, 'store'])->name('perfil.store');

// -*-*-*-*-*-*-*-*-*-*-*REGISTRO-*-*-*-*-*-*-*-*-*-*-*--*-*-*
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']); // este me mandara a muro si se registra un usuario

// -*-*-*-*-*-*-*-*-*-*-*LOGIN-*-*-*-*-*-*-*-*-*-*-*--*-*-*
// Controlador para usuarios no autenticados es decir para cuando se intente abrir la direccion autenticada en otro navegador
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);// Este resive los datos ingresados en el login con el request

// -*-*-*-*-*-*-*-*-*-*-*LOGOUT(CERRAR SESION)-*-*-*-*-*-*-*-*-*-*-*--*-*-*
// Nota: utilizar el get para cerrar sesion es inseguro debido a que se esta haciendo una peticion
// recordemos que get se muestra en la url y el post esta oculto debido a que aremos una peticionn a la BD
// es conveniente usar POST aunque no se mire en el controlador "LogoutController" esta usando un tipo de request
// que lleva los datos de la BD por eso es necesario utilizar POST para mayor seguridad.
Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

// -*-*-*-*-*-*-*-*-*-*-*POST LOGIN-*-*-*-*-*-*-*-*-*-*-*--*-*-*
// este es la seccion que se muestra si un usuario se a logeado o se a registrado
// aqui tambien se crearan los postss
// en la ruta hacemos referencia ala variable "user" creada en el controlador "PostController" para mandar a llamar el username
Route::get('/{user:username}', [PostController::class, 'index'])->name('post.index'); // route model binding
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/{user:username}/posts/{post}', [PostController::class, 'show'])->name('posts.show'); // para que al dar clic a la imagen nos lleve a otra vista donde podamos comentarla,likes , etc.
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

// -*-*-*-*-*-*-*-*-*-*-* COMENTARIOS POST -*-*-*-*-*-*-*-*-*-*-*--*-*-*
Route::post('/{user:username}/posts/{post}', [ComentarioController::class, 'store'])->name('comentarios.store');

// -*-*-*-*-*-*-*-*-*-*-*ALMACEN IMAGENES-*-*-*-*-*-*-*-*-*-*-*--*-*-*
Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');

// -*-*-*-*-*-*-*-*-*-*-* LIKE -*-*-*-*-*-*-*-*-*-*-*--*-*-*
Route::post('/posts/{post}/likes', [LikeController::class, 'store'])->name('posts.likes.store'); // esto sirve para dar like a una publicacioon
Route::delete('/posts/{post}/likes', [LikeController::class, 'destroy'])->name('posts.likes.destroy'); // esto sirve para dar eliminar el like de una publicacion

// -*-*-*-*-*-*-*-*-*-*-* FOLLOWERS -*-*-*-*-*-*-*-*-*-*-*--*-*-*
Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->name('users.follow');
Route::delete('/{user:username}/follow', [FollowerController::class, 'destroy'])->name('users.unfollow');