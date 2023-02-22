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
    private $nombreCompleto;
    /**
     * @var mixed
     */
    private $direccion;
    /**
     * @var mixed
     */
    private $DNI;
    /**
     * @var mixed
     */
    private $correo;
    /**
     * @var mixed
     */
    private $telefono;
    /**
     * @var mixed|string
     */
    private $contrasena;

    /**
     * @return string
     */


    /**
     * @var mixed
     */


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
