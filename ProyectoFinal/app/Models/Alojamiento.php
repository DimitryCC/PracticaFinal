<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alojamiento extends Model
{
    use HasFactory;
    protected $table='alojamientos';
    protected $primaryKey='ID';
    public $incrementing=false;
    public $timestamps=false;
    protected $fillable=['ID','nombre','adresa','numpero_personas','numero_habitaciones',
        'numero_camas','numero_banos','descripcio','tipo_alojamiento','tipo_vacacional','',
        'categoria','municipio','usuari'];
}
