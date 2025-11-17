<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    //
    protected $table = 'Tarea';

    // private $primaryKey = 'id';
    public $timestamps = false;

    public $incrementing = true;
}
