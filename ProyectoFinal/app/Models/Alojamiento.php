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
    protected $fillable=['ID','nombre','adresa','numeroPersonas','numeroHabitaciones',
        'numeroCamas','numeroBanos','direccion','tipoAlojamiento','tipoVacacional',
        'categoria','municipio','usuario'];
}
