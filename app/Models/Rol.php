<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'Rol';

    public $timestamps = false;

    public $incrementing = true;

    protected $fillable = ['nombre_rol'];

    public function participaciones()
    {
        return $this->hasMany(Participa::class, 'id_rol');
    }
}
