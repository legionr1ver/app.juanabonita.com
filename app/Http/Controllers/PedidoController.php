<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Articulo;
use App\Models\Envio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        
        DB::transaction(function() use($request,$user){

            $now = (new \DateTime('now', new \DateTimeZone('	America/Argentina/Buenos_Aires')))->format('Y-m-d H:i:s');

            $envio = Envio::where('id_cli_zonas',$user->cliente->id_cli_zonas)
                ->where('id_web_campanias',$request->id_web_campanias)
                ->whereNull('fecha_envio')
                ->first();

            if( !$envio ){
                $envio = new Envio();
                $envio->tipo_pedido = 'pedido';
                $envio->id_cli_zonas = $user->cliente->id_cli_zonas;
                $envio->id_web_usuarios = $user->id_web_usuarios;
                $envio->id_web_campanias = $request->id_web_campanias;
                $envio->save();
            }
    
            $pedido = new Pedido();
            $pedido->id_web_envios = $envio->id_web_envios;
            $pedido->id_web_usuarios = $user->id_web_usuarios;
            $pedido->id_cli_clientes = $user->id_cli_clientes;
            $pedido->estado = 130;
            $pedido->id_web_campanias = $request->id_web_campanias;
            $pedido->fecha_carga = $now;

            $pedido->monto = $request->collect('items')->reduce(function($carry,$i) use ($request){
                $a = Articulo::where('cod11',$i['cod11'])->where('id_web_campanias',$request->id_web_campanias)->first();
                return $carry + ($a->precio ?? 0) * $i['cantidad'];
            }, 0);

            $pedido->unidades = $request->collect('items')->reduce(function($carry,$i){
                return $carry + $i['cantidad'];
            }, 0);

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
                $newItem->estado = 130;
                $newItem->precio = $articulo->precio;
                $newItem->cuotas = $item['tipo'] == 'cuotas' ? 1 : 0;
                $newItem->fecha_alta = $now;
                $newItem->save();
            }
        });
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
