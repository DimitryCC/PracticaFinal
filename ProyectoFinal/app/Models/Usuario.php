<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    protected $table='usuarios';
    protected $primaryKey='ID';
    public $incrementing=false;
    public $timestamps=false;
    protected $fillable=['ID','DNI','nom_complet','telefon','contrasenya',
    'direccio','correu','administrador'];
}
