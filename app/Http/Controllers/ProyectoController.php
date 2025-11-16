<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|unique:Proyecto,id',
            'nombre' => 'required|string|max:255',

        ]);
    }

}
