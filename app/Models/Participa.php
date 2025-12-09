<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participa extends Model
{
    protected $table = 'Participa';

    public $timestamps = false;

    public $incrementing = true;

    protected $fillable = [
        'id_usuario',
        'id_rol',
        'id_proyecto'
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto');
    }
}
