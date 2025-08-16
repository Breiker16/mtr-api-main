<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function listar()
    {
        try {
            $empleados = Empleado::with('tipoIdentificacion')->get();
            return response()->json($empleados);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage(), 500);
        }
    }

    public function consultar($id)
    {
        try {
            $empleado = Empleado::with('tipoIdentificacion')->findOrFail($id);
            return response()->json($empleado);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage(), 500);
        }
    }

    public function guardar(Request $request)
    {
        try {
            $validado = $request->validate([
                "nombre" => "required|string",
                "apellidos" => "required|string",
                "identificacion" => "required|string|unique:tbl_empleado,identificacion",
                "telefono" => "required|string",
                "correo" => "required|email",
                "direccion" => "required|string",
                "puesto" => "required|string",
                "estado" => "required|boolean",
                "id_tipo_identificacion" => "required|exists:tbl_tipo_identificacion,id_tipo_identificacion"
            ]);

            Empleado::create($validado);
            return response()->json(1, 201);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage(), 500);
        }
    }

    public function actualizar(Request $request, $id)
    {
        try {
            $validado = $request->validate([
                "nombre" => "required|string",
                "apellidos" => "required|string",
                "identificacion" => "required|string|unique:tbl_empleado,identificacion,".$id.",id_empleado",
                "telefono" => "required|string",
                "correo" => "required|email",
                "direccion" => "required|string",
                "puesto" => "required|string",
                "estado" => "required|boolean",
                "id_tipo_identificacion" => "required|exists:tbl_tipo_identificacion,id_tipo_identificacion"
            ]);

            $empleado = Empleado::findOrFail($id);
            $empleado->update($validado);
            return response()->json(1);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage(), 500);
        }
    }
}
