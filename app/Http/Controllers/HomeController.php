<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke() /* Este invoke se manda a llamar automaticamente  desde el web quitando en el web las [] y el nombre de la clase '' */
    {
        //Obtener a quienes seguimos
        $ids = auth()->user()->followings->pluck('id')->toArray(); /* Lo que hace pluck es que se trae especificamente unos campos los que nosotros le demos */

        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20); //Where in se usa para cuando es un arreglo //El latest es para que nos muestre el ultimo registrado primero


        return view('home', [
            'posts' => $posts
        ]);
    }
}
