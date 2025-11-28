<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Tarea;
use App\Models\Estado;
use App\Models\Usuario;
use App\Models\Proyecto;
use App\Models\Participa;
use App\Models\Prioridad;
use Illuminate\Http\Request;

class CanvanController extends Controller{
    
    public function index()
    {
        
            // Proyectos donde el usuario es propietario
            $proyectosPropios = Proyecto::where('id_usuario', auth()->id())->get();
            
            // Proyectos donde el usuario es colaborador
            $idsProyectosColaborador = Participa::where('id_usuario', auth()->id())
                ->pluck('id_proyecto')
                ->toArray();
            
            $proyectosColaborador = Proyecto::whereIn('id', $idsProyectosColaborador)->get();
            
            // Combinar ambos (propios + colaborador)
            $proyectos = $proyectosPropios->merge($proyectosColaborador)->unique('id');
            
            $estados = Estado::all();
            $prioridad = Prioridad::all();
            $proyectoSeleccionado = null;
            $tareas = collect();
            $usuario = Usuario::all();
            $rol = Rol::all();

            return view('canvan', compact('proyectos', 'estados', 'prioridad', 'proyectoSeleccionado', 'tareas', 'usuario', 'rol'));

        
    }

    public function show($id)
    {
        // Obtener todos los proyectos del usuario (propios + colaborador)
        $proyectosPropios = Proyecto::where('id_usuario', auth()->id())->get();
        $idsProyectosColaborador = Participa::where('id_usuario', auth()->id())
            ->pluck('id_proyecto')
            ->toArray();
        $proyectosColaborador = Proyecto::whereIn('id', $idsProyectosColaborador)->get();
        $proyectos = $proyectosPropios->merge($proyectosColaborador)->unique('id');
        
        // Buscar el proyecto sin filtrar por usuario
        $proyectoSeleccionado = Proyecto::find($id);
        
        if (!$proyectoSeleccionado) {
            abort(404, 'Proyecto no encontrado.');
        }
        
        // Verificar acceso: debe ser propietario O colaborador
        $esPropiedad = ((int)$proyectoSeleccionado->id_usuario === (int)auth()->id());
        $esColaborador = in_array((int)$id, $idsProyectosColaborador);
        
        if (!$esPropiedad && !$esColaborador) {
            abort(403, 'No tienes permiso para ver este proyecto.');
        }
        
        $tareas = Tarea::where('id_proyecto', $proyectoSeleccionado->id)->get();
        $estados = Estado::all();
        $prioridad = Prioridad::all();
        
        // Datos para el modal de invitación
        // 1. Obtener IDs de usuarios que ya participan en el proyecto
        $usuariosEnProyecto = Participa::where('id_proyecto', $proyectoSeleccionado->id)
            ->pluck('id_usuario')
            ->toArray();
        
        // 2. Agregar al propietario del proyecto a la lista de exclusión
        $usuariosEnProyecto[] = $proyectoSeleccionado->id_usuario;
        
        // 3. Filtrar usuarios: mostrar solo los que NO están en el proyecto
        $usuario = Usuario::whereNotIn('id', $usuariosEnProyecto)->get();
        $rol = Rol::all();

        return view('canvan', compact(
            'proyectos',
            'proyectoSeleccionado',
            'tareas',
            'estados',
            'prioridad',
            'usuario',
            'rol',
        ));
    }
    
}
