<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index() 
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        //dd($request);
        //dd($request->get('username'));

        //Modificamos el request para que nos muestre la validacion de que el usuario esta repetido y no salga el unique de sql
        $request->request->add(['username' => Str::slug($request->username)]);

        //Validaciones de los campos
        $this->validate($request, [
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:20',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|min:14|confirmed' 
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            //Hashear los passwords
            'password' => Hash::make($request->password)
        ]);

        //Autenticando el usuario una vez creado
        //auth()->attempt([
            //'email' => $request->email,
            //'password' => $request->password,
        //]);

        //Otra forma de autenticar
        auth()->attempt($request->only('email','password'));

        //redireccionar al usuario una vez insertado a la base de datos
        return redirect()->route('post.index');
    }
}
