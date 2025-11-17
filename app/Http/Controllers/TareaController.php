<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'id_proyecto' => 'required|exists:Proyecto,id',  // ← OBLIGATORIO
        ]);

        $tarea = new Tarea;
        $tarea->nombre_tarea = $request->nombre_tarea;
        $tarea->desc_tarea = $request->descripcion;
        $tarea->fecha_limite = $request->fecha_limite;
        $tarea->id_prioridad = $request->id_prioridad ?? 1;  // Default
        $tarea->id_proyecto = $request->id_proyecto;  // ← DEL FORMULARIO
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarea $tarea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarea $tarea)
    {
        //
    }
}
