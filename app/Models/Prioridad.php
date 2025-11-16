<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prioridad extends Model
{
    //
    protected $table = 'Prioridad';

    // private $primaryKey = 'id';
    public $timestamps = false;

    public $incrementing = false;

    public function tareas()
    {
        return $this->belongsToMany(Tarea::class, 'id_prioridad');
    }
}
