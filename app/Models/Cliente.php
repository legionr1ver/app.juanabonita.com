<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Variable;

class Cliente extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'web_cache_clientes';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_web_cache_clientes';

    /**
     * 
     */
    public function limiteMuestrario() : int
    {
        if( $this->es_coordinadora == 1 ) return Variable::find('muestrario_coordinadora')->valor;
        if( $this->numero_cliente == 1 && $this->negocio == 'D' ) return Variable::find('muestrario_empresariaD')->valor;
        if( $this->numero_cliente == 1 && $this->negocio == 'E' ) return Variable::find('muestrario_empresariaE')->valor;
        return Variable::find('muestrario_revendedora')->valor;
    }
}
