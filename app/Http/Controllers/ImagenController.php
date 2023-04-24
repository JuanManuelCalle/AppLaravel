<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    public function store(Request $request)
    {
        //Tomando valores de la imagen que se mando 
        $imagen = $request->file('file');

        //Aca estamos creando un id unico para las imagenes para que no haya un error de nombre de imagen duplicado
        $nombreImagen = Str::uuid() . "." . $imagen->extension();

        //Utilizando interventacion image para hacer que las imagenes queden de un solo tamano
        $imagenServidor = Image::make($imagen);
        //Con esto se cambia de tamano
        $imagenServidor->fit(1000, 1000);

        //Moviendo la imagen a una parte del servido o mejor dicho una carpeta
        $imagenPath = public_path('uploads') . '/' . $nombreImagen;
        $imagenServidor->save($imagenPath);

        return response()->json(['imagen' => $nombreImagen]);
    }
}
