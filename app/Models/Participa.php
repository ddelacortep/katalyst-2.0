<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participa extends Model
{
    //
    protected $table = 'Participa';

    // private $primaryKey = 'id';
    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'id_usuario',
        'id_rol',
        'id_proyecto'
    ];

    public function rol()
    {
        return $this->hasOne(Rol::class, 'id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id');
    }

    public function proyecto()
    {
        return $this->hasMany(Proyecto::class, 'id');
    }
}
