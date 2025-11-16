<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    //
    protected $table = 'Tareas';

    // private $primaryKey = 'id';
    public $timestamps = false;

    public $incrementing = false;
}
