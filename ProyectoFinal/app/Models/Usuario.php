<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    private $administrador;
    protected $table='usuarios';
    protected $primaryKey='ID';
    public $incrementing=false;
    public $timestamps=false;
    /*
    protected $fillable=['ID','DNI','nombreCompleto','telefono','contrasena',
    'direccion','correo','apiTocken'];
    protected $hidden= ['apiTocken'];
    */
    protected $fillable=['DNI','nombreCompleto','telefono',
    'direccion','correo','contrasena'];
    protected $hidden= ['contrasena'];
}
