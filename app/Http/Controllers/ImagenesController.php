<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ImagenesController extends Controller
{
    public function codigo8($codigo8)
    {
        $response = Http::get( config('sisweb.url') . "/backend/print-mongo-imagen.php?codigo8=$codigo8" );
        
        if( strpos($response->body(), 'Exception') !== false ){
            return response('No hay imagen cargada para el artículo.', 404);
        }

        return response($response->body())
            ->header('Content-Type','image/jpg');
    }
}
