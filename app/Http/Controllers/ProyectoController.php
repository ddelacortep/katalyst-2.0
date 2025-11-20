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
        //
        $validated = $request->validate([
            'nombre_proyecto' => 'required|string|max:255',
        ]);

        $proyecto = new Proyecto;
        $proyecto->nombre_proyecto = $request->nombre_proyecto;
        $proyecto->id_usuario = auth()->id();
        $proyecto->favorito = false; // Asignar un valor predeterminado si es necesario
        $proyecto->save();

        return redirect()->route('proyecto')->with('success', 'Proyecto creado exitosamente.');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $proyectos = Proyecto::where('id_usuario', auth()->id())->get();
        $proyectoSeleccionado = Proyecto::where('id_usuario', auth()->id())->find($id);
        if (!$proyectoSeleccionado) {
            abort(403, 'No tienes permiso para ver este proyecto.');
        }
        $tareas = $proyectoSeleccionado ? Tarea::where('id_proyecto', $proyectoSeleccionado->id)->get() : collect();
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
        $proyecto->delete();

        return redirect('/proyecto');
    }
}