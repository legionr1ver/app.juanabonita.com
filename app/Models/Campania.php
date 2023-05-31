<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\CampaniaPreventa;

class Campania extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'web_campanias';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_web_campanias';

    /**
     * Obtiene la fecha de preventa asociada a la campaña
     */
    public function campaniaPreventa(): HasOne
    {
        return $this->hasOne(CampaniaPreventa::class, 'id_web_campanias', 'id_web_campanias');
    }
}
