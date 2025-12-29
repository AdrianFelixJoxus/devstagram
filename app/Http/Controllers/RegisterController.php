<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    //
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {

        // Modificar el request
        $request->request->add(['username' => str::slug($request->username)]);
        
        //dd($request);
        //validacion
        $request->validate([
            "name" => "required|max:30",
            "username" => "required|unique:users|min:3|max:20",
            "email" => "required|unique:users|email|max:60",
            "password" => "required|confirmed|min:6"
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password
        ]);

        // Autenticar usuario
        //auth::attempt(['email' => $request->email, 'password' => $request->password]);

        // Otra forma de autenticar
        auth::attempt($request->only('email', 'password'));

        // Redireccionar al usuario
        return redirect()->route('posts.index');
    }
}
