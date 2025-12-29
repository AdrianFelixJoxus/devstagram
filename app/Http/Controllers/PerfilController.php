<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Hash;


class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(User $user)
    {
        if(Auth::user()->id === $user->id) {
            return view('perfil.index');
        }
        Gate::authorize('index', $user);
        
    }

    public function store(Request $request, User $user)
    {
        // Modificar el request
        $request->request->add(['username' => str::slug($request->username)]);

        $credentials = $request->validate([
            'username' => ['required', 'unique:users,username,'.Auth::user()->id, 'min:3', 'max:20', 'not_in:twitter,editar-perfil'],
            'email' => ['unique:users,email,'.Auth::user()->email, 'max:60'],
            'password'
        ]);

        if($request->imagen) {
            $imagen = $request->file('imagen');

            $nombreImagen = Str::uuid() . ".{$imagen->extension()}";

            $manejador = new ImageManager(new Driver());
            $imagenServidor = $manejador->read($imagen);
            $imagenServidor->scale(1000,1000);
            

            $imagenPath = public_path("perfiles") . "/{$nombreImagen}";
            $imagenServidor->save($imagenPath);
        }

        //dd($user->password);
        if($request->password) {
            if(!Hash::check($request->password, $request->user()->password)) {
                return back()->with('password', 'Credenciales Incorrectas');
            }
        }


        // Guardar cambios
        $usuario = User::find(Auth::user()->id);
        $usuario->username = $request->username;
        $usuario->email = $request->email ?? $user->email ?? "";
        $usuario->password = $request->password2 ?? $usuario->password ?? "";
        $usuario->imagen = $nombreImagen ?? Auth::user()->imagen ?? "";
        $usuario->save();

        // Redireccionar al usuario
        return redirect()->route('posts.index', $usuario->username);


    }
}
