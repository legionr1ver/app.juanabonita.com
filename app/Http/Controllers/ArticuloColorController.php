<?php

namespace App\Http\Controllers;

use App\Models\ArticuloColor;
use Illuminate\Http\Request;

class ArticuloColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'id_web_campanias' => 'required',
        ]);

        return ArticuloColor::select('descripcion','codigo_color')->where('id_tab_campanias',$request->id_web_campanias)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ArticuloColor $articuloColor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ArticuloColor $articuloColor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArticuloColor $articuloColor)
    {
        //
    }
}
