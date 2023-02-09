<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;
    protected $table='reservas';
    protected $primaryKey='ID';
    public $incrementing=false;
    public $timestamps=false;
    protected $fillable=['usuarioId','AlojamientoId','FechaInicio','FechaFin'];
}
