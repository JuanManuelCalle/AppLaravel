<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    /* Con esto protegemos la vista de que otro usuario que no sea el dueño del perfil pueda editarlo */
    public function __construct()
    {
        $this->middleware('auth');   
    }

    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {
        $request->request->add(['username' => Str::slug($request->username)]);
        
        $this->validate($request, [
            'username' => ['required','unique:users,username,'.auth()->user()->id,'min:3','max:20','not_in:twitter,editar-perfil'], //Para Laravel como buena practica si se tiene mas de tres reglas ponerlas en un arreglo
            /* El que dice not_in es usuarios que no se pueden poner */
            /* In es para forzar a un usuario con el nombre de usuario que se ponga uno */
            /* Lo que tiene luego unique:users es para que si manda el mismo nombre aun asi permita cambiarlo, como si no lo hubiera cambiado */
        ]);

        if($request->imagen)
        {
            //Tomando valores de la imagen que se mando 
            $imagen = $request->file('imagen');

            //Aca estamos creando un id unico para las imagenes para que no haya un error de nombre de imagen duplicado
            $nombreImagen = Str::uuid() . "." . $imagen->extension();

            //Utilizando interventacion image para hacer que las imagenes queden de un solo tamano
            $imagenServidor = Image::make($imagen);
            //Con esto se cambia de tamano
            $imagenServidor->fit(1000, 1000);

            //Moviendo la imagen a una parte del servido o mejor dicho una carpeta
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        /* Guardar cambios */
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save();

        /* Redireccionar */
        return redirect()->route('post.index', $usuario->username);
    }
}
