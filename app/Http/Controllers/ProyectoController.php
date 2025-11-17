<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\Estado;
use App\Models\Proyecto;
use App\Models\Prioridad;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $proyectos = Proyecto::all();
        $estados = Estado::all(); // ← Añadir esto
        $prioridad = Prioridad::all(); // ← Añadir esto
        return view('proyecto', compact('proyectos', 'estados', 'prioridad'));
        
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
    public function show($id)
    {
        //
        $proyectos = Proyecto::all();  // Para el sidebar
        $proyectoSeleccionado = Proyecto::findOrFail($id);
        $tareas = Tarea::where('id_proyecto', $proyectoSeleccionado->id)->get();  // Solo tareas del proyecto
        $estados = Estado::all();
        $prioridad = Prioridad::all();
        
        return view('proyecto', compact(
            'proyectos', 
            'proyectoSeleccionado', 
            'tareas', 
            'estados', 
            'prioridad'
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
        //
    }
}
