<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    //
    protected $table = 'Proyecto';

    // private $primaryKey = 'id';
    public $timestamps = false;

    public $incrementing = true;

    public function tarea()
    {
        return $this->hasMany(Tarea::class, 'id');
    }

    public function participa()
    {
        return $this->belongsTo(Participa::class, 'id_proyecto');
    }

    protected $fillable = [
        'nombre_proyecto',
        'favorito'
    ];

    protected $casts = [
        'favorito' => 'boolean',
    ];
}
