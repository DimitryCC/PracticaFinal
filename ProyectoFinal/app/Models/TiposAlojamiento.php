<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiposAlojamiento extends Model
{
    use HasFactory;
    protected $table='tiposAlojameintos';
    protected $primaryKey='ID';
    public $incrementing=false;
    public $timestamps=false;
    protected $fillable=['ID','nombreTipo','idiomaId'];
}
