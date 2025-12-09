<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    //
    protected $table = 'Tarea';

    protected $primaryKey = 'id';

    public $timestamps = false;

    public $incrementing = true;

    protected $fillable = [
        'nombre_tarea',
        'desc_tarea',
        'fecha_limite',
        'id_proyecto',
        'id_prioridad',
        'fecha_creacion',
        'id_estado',
        'id_usuario',
        'id_usuario_creador',
        'id_usuario_asignado',
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto');
    }

    public function prioridad()
    {
        return $this->belongsTo(Prioridad::class, 'id_prioridad');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }

    public function creador()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_creador');
    }

    public function asignado()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_asignado');
    }
}
