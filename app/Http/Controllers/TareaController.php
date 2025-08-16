<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function listar()
    {
        try {
            $tareas = Tarea::with(['ordenTrabajo'])->get();
            return response()->json($tareas);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage(), 500);
        }
    }

    public function consultar($id)
    {
        try {
            $tarea = Tarea::with(['ordenTrabajo'])->findOrFail($id);
            return response()->json($tarea);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage(), 500);
        }
    }

    public function guardar(Request $request)
    {
        try {
            $validado = $request->validate([
                "nombre" => "required|string|max:255",
                "descripcion" => "required|string",
                "hora_inicio" => "required|date_format:H:i:s",
                "hora_fin" => "required|date_format:H:i:s",
                "estado" => "required|boolean",
                "id_orden" => "required|exists:tbl_orden_trabajo,id_orden_trabajo"
            ]);

            Tarea::create($validado);
            return response()->json(1, 201);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage(), 500);
        }
    }

    public function actualizar(Request $request, $id)
    {
        try {
            $validado = $request->validate([
                "nombre" => "sometimes|string|max:255",
                "descripcion" => "sometimes|string",
                "hora_inicio" => "sometimes|date_format:H:i:s",
                "hora_fin" => "sometimes|date_format:H:i:s",
                "estado" => "sometimes|boolean",
                "id_orden" => "sometimes|exists:tbl_orden_trabajo,id_orden_trabajo"
            ]);

            $tarea = Tarea::findOrFail($id);
            $tarea->update($validado);
            return response()->json(1);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage(), 500);
        }
    }

    public function estado(Request $request, $id)
    {
        try {
            $request->validate([
                "estado" => "required|boolean"
            ]);

            $tarea = Tarea::findOrFail($id);
            $tarea->update(["estado" => $request->estado]);
            return response()->json(1);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage(), 500);
        }
    }
}
