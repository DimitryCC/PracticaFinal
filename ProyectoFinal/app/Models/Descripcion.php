<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descripcion extends Model
{
    use HasFactory;
    protected $table='descripciones';
    protected $primaryKey='ID';
    public $incrementing=false;
    public $timestamps=false;
    protected $fillable=['ID','alojamientoId','descripcion','idiomaId'];
}
