<?php

namespace App\Http\Controllers;

use App\Models\ArticuloTalle;
use Illuminate\Http\Request;

class ArticuloTalleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'id_web_campanias' => 'required',
        ]);

        return ArticuloTalle::select('descripcion','descripcion')->where('id_tab_campanias',$request->id_web_campanias)->get();
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
    public function show(ArticuloTalle $articuloTalle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ArticuloTalle $articuloTalle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArticuloTalle $articuloTalle)
    {
        //
    }
}
