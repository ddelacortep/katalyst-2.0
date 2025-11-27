<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    //
    protected $table = 'Usuario';

    // private $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = ['id', 'nombre_usuario', 'correo', 'contrasena'];
    protected $hidden = ['contrasena'];
    

    public function participa()
    {
        return $this->hasMany(Participa::class, 'id_usuario');
    }

    public function tarea()
    {
        return $this->hasMany(Tarea::class, 'id_usuario');
    }

    public function proyecto(){
        return $this->hasMany(Proyecto::class, 'id_usuario');
    }
}
