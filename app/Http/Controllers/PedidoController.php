<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
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
        $user = Auth::user();

        if( !$user || $user->id_cli_clientes === null )
            throw new \Exception('No hay un cliente asociado al usuario.');

        $pedido = new Pedido();
        $pedido->id_web_envios = 1;
        $pedido->id_web_usuarios = $user->id_web_usuarios;
        $pedido->id_cli_clientes = $user->id_cli_clientes;
        $pedido->estado = 40;
        $pedido->id_web_campanias = $request->id_web_campanias;
        $pedido->save();

        foreach( $request->items as $item )
        {
            $articulo = Articulo::where('cod11',$item['cod11'])->where('id_web_campanias',$request->id_web_campanias)->first();
            
            if( !$articulo )
                throw new \Exception("No existe el articulo {$item['cod11']} en la campaña $request->id_web_campanias.");

            $newItem = new PedidoItem();
            $newItem->id_web_pedidos = $pedido->id_web_pedidos;
            $newItem->idArticulo = $articulo->id_web_cache_articulos;
            $newItem->cod11 = $articulo->cod11;
            $newItem->code = $articulo->Code;
            $newItem->tipo = $articulo->Tipo;
            $newItem->color = $articulo->Color;
            $newItem->talle = $articulo->Talle;
            $newItem->cantidad = $item['cantidad'];
            $newItem->muestrario = $item['tipo'] == 'muestrario' ? 1 : null;
            $newItem->estado = 40;
            $newItem->precio = $articulo->precio;
            $newItem->cuotas = $item['tipo'] == 'cuotas' ? 1 : 0;
            $newItem->save();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}