<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    use HasFactory;
    protected $table='valoraciones';
    protected $primaryKey=['usuari_id','Alojamiento_id'];
    public $incrementing=false;
    public $timestamps=false;
    protected $fillable=['usuari_id','Alojamiento_id','texto','puntuacion'];
}
