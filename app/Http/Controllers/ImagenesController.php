<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ImagenesController extends Controller
{
    public function codigo8($codigo8)
    {
        $response = Http::get( config('sisweb.url') . "/backend/print-mongo-imagen.php?codigo8=$codigo8" );
        //$response->throw()->body();

        return response($response->body())
            ->header('Content-Type','image/jpg');
    }
}
