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

    public function tareas()
    {
        return $this->hasMany(Tarea::class, 'id_proyecto');
    }

    public function participa()
    {
        return $this->belongsTo(Participa::class, 'id_proyecto');
    }

    public function usuario(){
        return $this->belongsToMany(Usuario::class, 'id');
    }

    protected $fillable = [
        'nombre_proyecto',
        'favorito',
        'id_usuario'
    ];

    protected $casts = [
        'favorito' => 'boolean',
    ];
}
