<?php

namespace App\Http\Controllers;

use App\Models\EstadoOrden;
use Illuminate\Http\Request;

class EstadoOrdenController extends Controller
{
    public function listar()
    {
        try {
            $estados = EstadoOrden::all();
            return response()->json($estados);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage(), 500);
        }
    }

    public function consultar($id)
    {
        try {
            $estado = EstadoOrden::findOrFail($id);
            return response()->json($estado);
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

            EstadoOrden::create($validado);
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

            $estado = EstadoOrden::findOrFail($id);
            $estado->update($validado);
            return response()->json(1);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage(), 500);
        }
    }
}
