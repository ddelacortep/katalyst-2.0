<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    //
    protected $table = 'Usuario';

    // private $primaryKey = 'id';
    public $timestamps = false;

    public $incrementing = false;

    public function participa()
    {
        return $this->hasMany(Participa::class, 'id_usuario');
    }

    public function tarea()
    {
        return $this->hasMany(Tarea::class, 'id_usuario');
    }
}
