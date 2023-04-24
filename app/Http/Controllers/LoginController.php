<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request) //Le pasamos esto para que nos mande las variables
    {

        //Validacion de los campos
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required' 
        ]);

        //Haciendo la validacion para todo el inicio de sesion
        if(!auth()->attempt($request->only('email', 'password'), $request->remember))
        {
            return back()->with('mensaje', 'Las credenciales son incorrectas');
        }

        return redirect()->route('post.index', auth()->user()->username);
    }
}
