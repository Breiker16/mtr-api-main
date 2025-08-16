<?php

namespace App\Http\Controllers;

use App\Models\TipoIdentificacion;
use Illuminate\Http\Request;

class TipoIdentificacionController extends Controller
{
    public function listar()
    {
        try {
            $tipos = TipoIdentificacion::get();
            return response()->json($tipos);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage(), 500);
        }
    }

    public function consultar($id)
    {
        try {
            $tipo = TipoIdentificacion::findOrFail($id);
            return response()->json($tipo);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage(), 500);
        }
    }

    public function guardar(Request $request)
    {
        try {
            $validado = $request->validate([
                "nombre" => "required|string|max:255"
            ]);

            TipoIdentificacion::create($validado);
            return response()->json(1, 201);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage(), 500);
        }
    }

    public function actualizar(Request $request, $id)
    {
        try {
            $validado = $request->validate([
                "nombre" => "required|string|max:255"
            ]);

            $tipo = TipoIdentificacion::findOrFail($id);
            $tipo->update($validado);
            return response()->json(1);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage(), 500);
        }
    }
}
