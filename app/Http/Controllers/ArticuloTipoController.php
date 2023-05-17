<?php

namespace App\Http\Controllers;

use App\Models\ArticuloTipo;
use Illuminate\Http\Request;

class ArticuloTipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'id_web_campanias' => 'required',
        ]);

        return ArticuloTipo::select('descripcion','codigo_tipo')->where('id_tab_campanias',$request->id_web_campanias)->get();
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
    public function show(ArticuloTipo $articuloTipo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ArticuloTipo $articuloTipo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArticuloTipo $articuloTipo)
    {
        //
    }
}
