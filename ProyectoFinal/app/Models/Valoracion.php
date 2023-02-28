<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    use HasFactory;
    protected $table='valoraciones';
    protected $primaryKey=['AlojamientoId', 'usuarioId'];
    public $incrementing=false;
    public $timestamps=false;
    protected $fillable=['usuarioId','AlojamientoId','texto','puntuacion'];
}
