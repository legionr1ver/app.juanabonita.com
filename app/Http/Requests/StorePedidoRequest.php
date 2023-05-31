<?php

namespace App\Http\Requests;

use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Articulo;
use App\Models\Pedido;
use App\Models\PedidoItem;

class StorePedidoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id_web_campanias' => 'required|exists:web_campanias,id_web_campanias',
            'items' => [
                'required',
                'array',
                function(string $attribute, mixed $value, Closure $fail){

                    $cliente = Auth::user()->cliente ?? null;

                    if( !$cliente )
                        $fail("El usuario no tiene un cliente asignado.");

                     $muestrariosCampania = (int)PedidoItem::whereHas('pedido', function (Builder $query) use($cliente) {
                        $query->where('id_web_campanias', $this->id_web_campanias);
                        $query->where('id_cli_clientes', $cliente->id_cli_clientes);
                    })
                    ->where('muestrario', 1)
                    ->whereNotIn('estado', [80,160,31,70,120])
                    ->sum('cantidad');

                    $muestrariosPedido = collect($value)->reduce(function($carry,$i){
                        return $carry + ($i['tipo'] == 'muestrario' ? $i['cantidad'] : 0);
                    }, 0);

                    if( $muestrariosPedido > 0 && $muestrariosPedido + $muestrariosCampania > $cliente->limiteMuestrario() ){
                        $fail("El pedido excede la cantidad de muestrarios permitidos. Tiene $muestrariosCampania muestrarios en la campaña.");
                    }
                }
            ],
            'items.*.cod11' => [
                'required',
                function(string $attribute, mixed $value, Closure $fail){

                    $articulo = Articulo::where('cod11',$value)
                        ->where('id_web_campanias',$this->id_web_campanias)
                        ->first();

                    if ($articulo === null) {
                        $fail("El articulo no esta vigente en la campaña.");
                    }
                }
            ],
            'items.*.tipo' => 'required|in:normal,muestrario,cuotas',
            'items.*.cantidad' => 'required|numeric|min:1',
        ];
    }
}
