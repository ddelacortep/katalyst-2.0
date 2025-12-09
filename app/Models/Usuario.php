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

    public function getRoleInProject($projectId)
    {
        $participa = Participa::where('id_usuario', $this->id)
                               ->where('id_proyecto', $projectId)
                               ->first();
        
        if (!$participa || !$participa->rol) {
            return null;
        }
        
        return $participa->rol->nombre_rol;
    }

    public function isAdminIn($projectId)
    {
        return $this->getRoleInProject($projectId) === 'Admin';
    }

    public function isEditorIn($projectId)
    {
        return $this->getRoleInProject($projectId) === 'Editor';
    }

    public function isVisorIn($projectId)
    {
        return $this->getRoleInProject($projectId) === 'Visor';
    }

    public function isOwnerOf($projectId)
    {
        return Proyecto::where('id', $projectId)
                       ->where('id_usuario', $this->id)
                       ->exists();
    }

    public function canManageIn($projectId)
    {
        $role = $this->getRoleInProject($projectId);
        return in_array($role, ['Admin', 'Editor']);
    }

    public function hasAccessToProject($projectId)
    {
        return $this->isOwnerOf($projectId) || 
               Participa::where('id_usuario', $this->id)
                        ->where('id_proyecto', $projectId)
                        ->exists();
    }
}
