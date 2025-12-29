<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImagenController extends Controller
{
    public function store(Request $request)
    {
        $imagen = $request->file('file');
        $nombreImagen = Str::uuid() . ".{$imagen->extension()}";
        $manejador = new ImageManager(new Driver());
        $imagenServidor = $manejador->read($imagen);
        $imagenServidor->scale(1000,1000);
        

        $imagenPath = public_path("uploads") . "/{$nombreImagen}";
        $imagenServidor->save($imagenPath);

        return response()->json(['imagen' => $nombreImagen]);
    }
}
