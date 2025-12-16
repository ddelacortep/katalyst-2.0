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
            'usuario_identificador' => 'required|string',
            'id_rol' => 'required|exists:Rol,id',
        ]);

        $idProyecto = $request->id_proyecto;
        $usuarioIdentificador = trim($request->usuario_identificador);
        
        // Buscar usuario por nombre de usuario o correo electrónico
        $usuario = Usuario::where('nombre_usuario', $usuarioIdentificador)
                          ->orWhere('correo', $usuarioIdentificador)
                          ->first();
        
        if (!$usuario) {
            return redirect()->back()->with('error', 'Usuario no encontrado. Verifica que el nombre de usuario o correo electrónico sea correcto.');
        }
        
        $idUsuario = $usuario->id;

        $proyecto = Proyecto::findOrFail($idProyecto);
        $user = auth()->user();

        $rolQuienInvita = $user->getRoleInProject($proyecto->id);
        
        if (!in_array($rolQuienInvita, ['Admin', 'Editor'])) {
            return redirect()->back()->with('error', 'Solo Admin y Editor pueden invitar usuarios.');
        }
        
        if ($rolQuienInvita === 'Editor' && $request->id_rol == 1) {
            return redirect()->back()->with('error', 'Solo el Admin puede asignar el rol Admin.');
        }

        $yaExiste = Participa::where('id_proyecto', $idProyecto)
            ->where('id_usuario', $idUsuario)
            ->exists();

        if ($yaExiste) {
            return redirect()->back()->with('error', 'El usuario ya está en el proyecto.');
        }

        try {
            $participa = new Participa();
            $participa->id_proyecto = $idProyecto;
            $participa->id_usuario = $idUsuario;
            $participa->id_rol = $request->id_rol;
            $participa->save();

            return redirect()->route('proyecto.show', $idProyecto)
                ->with('success', 'Usuario invitado correctamente.');
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
        $proyecto = Proyecto::findOrFail($proyectoId);
        $user = auth()->user();
        
        if ($proyecto->id_usuario !== $user->id) {
            return redirect()->back()->with('error', 'Solo el Admin del proyecto puede eliminar usuarios.');
        }
        
        if ($usuarioId == $user->id) {
            return redirect()->back()->with('error', 'No puedes eliminarte a ti mismo del proyecto.');
        }
        
        Participa::where('id_proyecto', $proyectoId)
                 ->where('id_usuario', $usuarioId)
                 ->delete();
        
        return redirect()->back()->with('success', 'Usuario removido del proyecto.');
    }
}
