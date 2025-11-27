<?php

namespace App\Http\Controllers;

use App\Models\Participa;
use App\Models\Proyecto;
use App\Models\Usuario;
use Illuminate\Http\Request;

class ParticipaController extends Controller
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
     * Invitar un usuario a colaborar en el proyecto
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_proyecto' => 'required|exists:Proyecto,id',
            'id_usuario' => 'required',
            'id_rol' => 'required|exists:Rol,id',
        ]);

        $idProyecto = $request->id_proyecto;
        $idUsuario = $request->id_usuario;
        
        // Si el id_usuario no es numérico, buscar el usuario por nombre
        if (!is_numeric($idUsuario)) {
            $usuario = Usuario::where('nombre_usuario', $idUsuario)->first();
            if (!$usuario) {
                return redirect()->back()->with('error', 'Usuario no encontrado.');
            }
            $idUsuario = $usuario->id;
        }

        // Verificar que el proyecto existe
        $proyecto = Proyecto::findOrFail($idProyecto);

        // Debug: Obtener IDs como enteros
        $authUserId = (int) auth()->id();
        $proyectoOwnerId = (int) $proyecto->id_usuario;

        // Verificar que el usuario que invita es el propietario del proyecto
        if ($proyectoOwnerId !== $authUserId) {
            return redirect()->back()->with('error', 
                "Solo el propietario puede invitar. Tu ID: {$authUserId}, Propietario: {$proyectoOwnerId}");
        }

        // Verificar que el usuario no esté ya en el proyecto
        $yaExiste = Participa::where('id_proyecto', $idProyecto)
            ->where('id_usuario', $idUsuario)
            ->exists();

        if ($yaExiste) {
            return redirect()->back()->with('error', 'El usuario ya está en el proyecto.');
        }

        // Crear la participación: guardar id_proyecto, id_usuario, id_rol
        try {
            $participa = new Participa();
            $participa->id_proyecto = $idProyecto;
            $participa->id_usuario = $idUsuario;
            $participa->id_rol = $request->id_rol;
            $participa->save();

            return redirect()->route('proyecto.show', $idProyecto)
                ->with('success', 'Usuario invitado correctamente. Ahora tiene acceso al proyecto.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Participa $participa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Participa $participa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Participa $participa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * Eliminar un colaborador del proyecto
     */
    public function destroy($proyectoId, $usuarioId)
    {
        // Verificar que el proyecto existe
        $proyecto = Proyecto::findOrFail($proyectoId);

        // Verificar que el usuario que elimina es el propietario
        if ($proyecto->id_usuario !== auth()->id()) {
            return redirect()->back()->with('error', 'Solo el propietario puede eliminar colaboradores.');
        }

        // Eliminar la participación de la base de datos
        $eliminado = Participa::where('id_proyecto', $proyectoId)
            ->where('id_usuario', $usuarioId)
            ->delete();

        if ($eliminado) {
            return redirect()->route('proyecto.show', $proyectoId)
                ->with('success', 'Colaborador eliminado correctamente. Ya no tiene acceso al proyecto.');
        }

        return redirect()->back()->with('error', 'No se pudo eliminar el colaborador.');
    }
}
