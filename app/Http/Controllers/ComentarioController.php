<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $request, User $user, Post $post)
    {
        //Validacion
        $this->validate($request, [
            'comentario' => 'required|max:255'
        ]);

        //Almacenar comentario
        Comentario::create([
            'user_id' => auth()->user()->id, //Esto es para tomar el id del usuario que lo esta haciendo no el que aprece en la url
            'post_id' => $post->id,
            'comentario' => $request->comentario
        ]);

        //Imprimir mensaje
        return back()->with('mensaje', 'Comentario realizado correctamente');
    }
}
