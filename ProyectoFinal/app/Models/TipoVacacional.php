<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoVacacional extends Model
{
    use HasFactory;
    protected $table='tiposvacacional';
    protected $primaryKey='ID';
    public $incrementing=false;
    public $timestamps=false;
}