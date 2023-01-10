<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiposAlojameinto extends Model
{
    use HasFactory;
    protected $table='tiposalojameintos';
    protected $primaryKey='ID';
    public $incrementing=false;
    public $timestamps=false;
}
