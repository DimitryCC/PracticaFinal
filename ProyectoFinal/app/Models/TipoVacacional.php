<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoVacacional extends Model
{
    use HasFactory;
    protected $table='tiposVacacional';
    protected $primaryKey='ID';
    public $incrementing=false;
    public $timestamps=false;
    protected $fillable=['ID','nombre_tipo','idioma_id'];

}
