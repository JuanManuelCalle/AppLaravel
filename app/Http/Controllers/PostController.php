<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);  //Con el except lo que hacemos es que nos permita mostrar esa pagina a alguien que no esta logueado
    }
    public function index(User $user) //Para hacer que reciba una varibale como es el el caso del archivoo web en el route de 
    //{user} le pasamos esa varibale y el la espera como modelo entonces se llama el modelo en el que se encuentra en este caso user
    {
        //Creando o viendo las publicaciones del usuario por persona
        $posts = Post::where('user_id', $user->id)->latest()->paginate(12); //Con esto hacemos el query de get

        return view('dashboard', [
            'user' => $user,
            'posts' => $posts
        ]); //Pasar una variable a una vista
    }

    public function create() //Este retorna una vista el que nos permite verlo
    {
        return view('posts.create');
    }

    public function store(Request $request) //Store es que nos guarda en la base de datos
    {
        $this->validate($request, [
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);

        //Post::create([
            //'titulo' => $request->titulo,
            //'descripcion' => $request->descripcion,
            //'imagen' => $request->imagen,
            //'user_id' => auth()->user()->id
        //]);

        //Otra forma de crear un registro
        //$post = new Post;
        //$post->titulo = $request->titulo;
        //$post->descripcion = $request->descripcion;
        //$post->imagen = $request->imagen;
        //$post->user_id = auth()->user()->id;

        //Otra forma de crear un registro
        $request->user()->posts()->create([ //User define que usuario llena el formulario, luego se accede a la relacion del modelo y por ultimo se crea el modelo
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('post.index', auth()->user()->username);
    }

    public function show(User $user,Post $post) /* ESTO SOLO SE VA A UTILIZAR EN EL CASO DE QUE QUERAMOS MOSTRAR SOLO 1 PARA MOSTRAR MUCHOS EL METODO ES EL INDEX*/
    {
        return view('posts.show', [
            'post' => $post,
            'user' => $user
        ]);
    }

    public function destroy(Post $post){

        $this->authorize('delete', $post);
        $post->delete();

        //Eliminar la imagen una vez eliminando el post
        $imagen_path = public_path('uploads/' . $post->imagen);

        if(File::exists($imagen_path)){
            unlink($imagen_path);
        }

        return redirect()->route('post.index', auth()->user()->username);

    }
}
