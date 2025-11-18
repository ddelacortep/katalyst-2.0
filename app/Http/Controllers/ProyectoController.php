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
    public function index()
    {

        $proyectos = Proyecto::all();
        $estados = Estado::all(); // ← Añadir esto
        $prioridad = Prioridad::all(); // ← Añadir esto
        $proyectoSeleccionado = null; // No hay proyecto seleccionado en la vista inicial
        $tareas = collect(); // Colección vacía de tareas

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
    public function show($id)
    {
        //
        $proyectos = Proyecto::all();
        $proyectoSeleccionado = Proyecto::find($id);
        $tareas = Tarea::where('id_proyecto', $proyectoSeleccionado->id)->get();
        $estados = Estado::all();
        $prioridad = Prioridad::all();

        return view('proyecto', compact(
            'proyectos',
            'proyectoSeleccionado',
            'tareas',
            'estados',
            'prioridad', // <-- pasa la tarea a editar
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
