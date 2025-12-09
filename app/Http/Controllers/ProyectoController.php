<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\Participa;
use App\Models\Prioridad;
use App\Models\Proyecto;
use App\Models\Rol;
use App\Models\Tarea;
use App\Models\Usuario;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

        return view('proyecto', compact('proyectos', 'estados', 'prioridad', 'proyectoSeleccionado', 'tareas', 'usuario', 'rol'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_proyecto' => 'required|string|max:255',
        ]);

        $proyecto = new Proyecto;
        $proyecto->nombre_proyecto = $request->nombre_proyecto;
        $proyecto->id_usuario = auth()->id();
        $proyecto->favorito = false;
        $proyecto->save();

        $participa = new Participa();
        $participa->id_proyecto = $proyecto->id;
        $participa->id_usuario = auth()->id();
        $participa->id_rol = 1;
        $participa->save();

        return redirect()->route('proyecto')->with('success', 'Proyecto creado exitosamente.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
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
        
        // Obtener tareas del proyecto con filtro
        $tareasQuery = Tarea::where('id_proyecto', $proyectoSeleccionado->id);
        
        // Aplicar filtro según la selección
        $filtro = $request->get('filtro');
        
        if ($filtro) {
            switch ($filtro) {
                case 'fecha':
                    // Ordenar por fecha límite (más cercanas a hoy primero)
                    $tareasQuery->orderByRaw("ABS(DATEDIFF(day, GETDATE(), fecha_limite)) ASC");
                    break;
                    
                case 'estado':
                    // Ordenar por estado: Pendiente, En progreso, Completado
                    $tareasQuery->join('Estado', 'Tarea.id_estado', '=', 'Estado.id')
                        ->orderByRaw("CASE Estado.nombre_estado 
                            WHEN 'Pendiente' THEN 1 
                            WHEN 'En progreso' THEN 2 
                            WHEN 'Completado' THEN 3 
                            ELSE 4 END")
                        ->select('Tarea.*');
                    break;
                    
                case 'prioridad':
                    // Ordenar por prioridad: Alta, Media, Baja
                    $tareasQuery->join('Prioridad', 'Tarea.id_prioridad', '=', 'Prioridad.id')
                        ->orderByRaw("CASE Prioridad.nombre_prioridad 
                            WHEN 'Alta' THEN 1 
                            WHEN 'Media' THEN 2 
                            WHEN 'Baja' THEN 3 
                            ELSE 4 END")
                        ->select('Tarea.*');
                    break;
            }
        }
        
        $tareas = $tareasQuery->get();
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

        return view('proyecto', compact(
            'proyectos',
            'proyectoSeleccionado',
            'tareas',
            'estados',
            'prioridad',
            'usuario',
            'rol',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proyecto $proyecto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proyecto $proyecto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proyecto $proyecto)
    {
        // Verificar que el usuario es el propietario
        if ((int)$proyecto->id_usuario !== (int)auth()->id()) {
            return redirect()->back()->with('error', 'Solo el propietario puede eliminar el proyecto.');
        }

        // Eliminar primero todas las participaciones del proyecto
        Participa::where('id_proyecto', $proyecto->id)->delete();
        
        // Eliminar todas las tareas del proyecto
        Tarea::where('id_proyecto', $proyecto->id)->delete();
        
        // Ahora eliminar el proyecto
        $proyecto->delete();

        return redirect('/proyecto')->with('success', 'Proyecto eliminado correctamente.');
    }
}