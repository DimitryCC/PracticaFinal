<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    /**
     * @var mixed
     */
    public $nombreCompleto;
    /**
     * @var mixed
     */
    public $direccion;
    /**
     * @var mixed
     */
    public $DNI;
    /**
     * @var mixed
     */
    public $correo;
    /**
     * @var mixed
     */
    public $telefono;
    /**
     * @var mixed|string
     */
    public $contrasena;
    /**
     * @var mixed
     */


    public $administrador;
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
    protected $hidden= ['apiTocken','contrasena', 'administrador'];
}
