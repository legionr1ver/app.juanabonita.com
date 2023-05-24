<?php

namespace App\Http\Controllers;

use App\Models\Campania;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaniaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Campania $campania)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campania $campania)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campania $campania)
    {
        //
    }

    /**
     * Muestra las campañas habilitadas para el usuario logueado
     */
    public function habilitadas()
    {
        $user = Auth::user();
        return Campania::where('habilitado', 1)->where('sistema',$user->cliente->sistema)->get();
    }
}
