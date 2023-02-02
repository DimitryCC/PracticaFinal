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
    public $nom_complet;
    /**
     * @var mixed
     */
    public $direccio;
    /**
     * @var mixed
     */
    public $DNI;
    /**
     * @var mixed
     */
    public $correu;
    /**
     * @var mixed
     */
    public $telefon;
    /**
     * @var mixed|string
     */
    public $contrasenya;
    /**
     * @var mixed
     */


    public $administrador;
    protected $table='usuarios';
    protected $primaryKey='ID';
    public $incrementing=false;
    public $timestamps=false;
    protected $fillable=['ID','DNI','nom_complet','telefon','contrasenya',
    'direccio','correu','administrador'];
}
