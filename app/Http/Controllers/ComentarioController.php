<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ComentarioController extends Controller
{
    public static function store(Request $request, User $user, Post $post)
    {

        // Validar
        $request->validate([
            'comentario' => 'required|max:255'
        ]);

        // Almacenar el resultado
        Comentario::create([
            'user_id' => Auth::user()->id,
            'post_id' => $post->id,
            'comentario' => $request->comentario
        ]);

        // imprimir un mensaje
        return back()->with('mensaje', 'Comentario Realizado Correctamente');
    }
}
