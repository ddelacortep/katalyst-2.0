<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\Prioridad;
use App\Models\Proyecto;
use App\Models\Tarea;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener todos los proyectos
        $proyectos = Proyecto::all();
        
        // Aplicar filtro según la selección
        $filtro = $request->get('filtro');
        
        if ($filtro) {
            switch ($filtro) {
                case 'fecha_creacion':
                    // Ordenar por ID (más recientes primero si el ID es autoincremental)
                    $proyectos = $proyectos->sortByDesc('id');
                    break;
                    
                case 'estado':
                    // Ordenar alfabéticamente por nombre
                    $proyectos = $proyectos->sortBy('estado');
                    break;
                    
                case 'prioridad':
                    // Mostrar favoritos primero
                    $proyectos = $proyectos->sortByDesc('prioridad');
                    break;
            }
        }
        
        $estados = Estado::all();
        $prioridad = Prioridad::all();
        $proyectoSeleccionado = null;
        $tareas = collect();

        return view('proyecto', compact('proyectos', 'estados', 'prioridad', 'proyectoSeleccionado', 'tareas'));

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
        $proyecto->favorito = false; // Asignar un valor predeterminado si es necesario
        $proyecto->save();

        return redirect()->route('proyecto')->with('success', 'Proyecto creado exitosamente.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        //
        $proyectos = Proyecto::all();
        $proyectoSeleccionado = Proyecto::find($id);
        
        // Obtener tareas del proyecto con filtro usando Eloquent
        $tareasQuery = Tarea::where('id_proyecto', $proyectoSeleccionado->id);
        
        // Aplicar filtro según la selección
        $filtro = $request->get('filtro');
        
        if ($filtro) {
            switch ($filtro) {
                    
                case 'fecha_limite':
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

        return view('proyecto', compact(
            'proyectos',
            'proyectoSeleccionado',
            'tareas',
            'estados',
            'prioridad',
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
