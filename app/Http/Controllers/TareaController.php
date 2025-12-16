<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\Prioridad;
use App\Models\Proyecto;
use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Tarea::query();

        $validFiltros = ['fecha', 'prioridad', 'estado'];
        $errorFiltro = null;
        if ($request->filled('filtro')) {
            if (in_array($request->filtro, $validFiltros)) {
                switch ($request->filtro) {
                    case 'fecha':
                        $query->orderBy('fecha_limite');
                        break;
                    case 'prioridad':
                        $query->orderBy('id_prioridad', 'desc');
                        break;
                    case 'estado':
                        $query->orderBy('id_estado');
                        break;
                }
            } else {
                $errorFiltro = 'Filtro no válido.';
            }
        }

        $tareas = $query->get();
        $proyectos = Proyecto::all();
        $estados = Estado::all();
        $prioridad = Prioridad::all();
        $proyectoSeleccionado = null;
        // Puedes ajustar la lógica para seleccionar el proyecto si lo necesitas
        return view('proyecto', compact('proyectos', 'proyectoSeleccionado', 'tareas', 'estados', 'prioridad', 'errorFiltro'));
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
            'nombre_tarea' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_limite' => 'nullable|date',
            'id_prioridad' => 'nullable|exists:Prioridad,id',
            'id_proyecto' => 'required|exists:Proyecto,id',
            'id_estado' => 'nullable|exists:Estado,id',  // ← OBLIGATORIO
        ]);

        $tarea = new Tarea;
        $tarea->nombre_tarea = $request->nombre_tarea;
        $tarea->desc_tarea = $request->descripcion;
        $tarea->fecha_limite = $request->fecha_limite;
        $tarea->id_prioridad = $request->id_prioridad ?? 1;  // Default
        $tarea->id_proyecto = $request->id_proyecto;  // ← DEL FORMULARIO
        $tarea->id_estado = $request->id_estado ?? $tarea->id_estado;  // Default
        $tarea->fecha_creacion = now();
        $tarea->save();

        // Redirigir al mismo proyecto
        return redirect()->route('proyecto.show', $request->id_proyecto)
            ->with('success', 'Tarea creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarea $tarea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarea $tarea)
    {
        // Retorna la vista de edición con la tarea
        $proyectos = Proyecto::all();
        $proyectoSeleccionado = Proyecto::find($tarea->id_proyecto);
        if (! $proyectoSeleccionado) {
            abort(404, 'Proyecto no encontrado para esta tarea.');
        }
        $tareas = Tarea::where('id_proyecto', $proyectoSeleccionado->id)->get();
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarea $tarea)
    {
        //
        $validated = $request->validate([
            'nombre_tarea' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_limite' => 'nullable|date',
            'id_prioridad' => 'nullable|exists:Prioridad,id',
            'id_estado' => 'nullable|exists:Estado,id',
        ]);

        // Actualizar los campos
        $tarea->nombre_tarea = $request->nombre_tarea;
        $tarea->desc_tarea = $request->descripcion;
        $tarea->fecha_limite = $request->fecha_limite;
        $tarea->id_prioridad = $request->id_prioridad ?? $tarea->id_prioridad;
        $tarea->id_estado = $request->id_estado ?? $tarea->id_estado;
        $tarea->save();

        // Redirigir al proyecto con mensaje de éxito
        return redirect()->route('proyecto.show', $tarea->id_proyecto)
            ->with('success', 'Tarea actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarea $tarea)
    {
        $idProyecto = $tarea->id_proyecto;
    
        $tarea->delete();                  // Eliminar la tarea

        return redirect()->route('proyecto.show', $idProyecto)
            ->with('success', 'Tarea eliminada exitosamente.');
    }

    public function actualizarEstado(Request $request, $id)
    {
        $tarea = Tarea::find($id);
        
        if (!$tarea) {
            return response()->json(['error' => 'Tarea no encontrada'], 404);
        }

        // Validar que el estado existe
        $nuevoEstado = $request->input('estado_id');
        $estado = \App\Models\Estado::find($nuevoEstado);
        
        if (!$estado) {
            return response()->json(['error' => 'Estado no válido'], 400);
        }

        // Actualizar el estado de la tarea
        $tarea->id_estado = $nuevoEstado;
        $tarea->save();

        return response()->json([
            'success' => true,
            'mensaje' => 'Estado actualizado correctamente',
            'tarea' => $tarea,
            'nuevo_estado' => $estado->nombre_estado
        ]);
    }
}
