<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    //
    protected $table = 'Proyecto';

    // private $primaryKey = 'id';
    public $timestamps = false;

    public $incrementing = false;

    public function tarea()
    {
        return $this->hasMany(Tarea::class, 'id');
    }

    public function particip()
    {
        return $this->belongsTo(Participa::class, 'id_proyecto');
    }
}
