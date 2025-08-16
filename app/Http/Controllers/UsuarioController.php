<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function listar(): JsonResponse
    {
        try {
            return response()->json(Usuario::get());
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage(), 500);
        }
    }

    public function consultar($id): JsonResponse
    {
        try {
            return response()->json(Usuario::find($id));
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage(), 500);
        }
    }

    public function guardar(Request $request): JsonResponse
    {
        try {
            $validado = $request->validate([
                "nombre" => "required|string",
                "apellidos" => "required|string",
                "acceso" => "required|string",
                "secreto" => "required|string",
                "estado" => "required|boolean"
            ]);

            $validado["secreto"] = password_hash($validado["secreto"], PASSWORD_DEFAULT);
            Usuario::create($validado);
            return response()->json(1, 201);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage(), 500);
        }
    }

    public function actualizar(Request $request): JsonResponse
    {
        try {
            $validado = $request->validate([
                "id_usuario" => "required|integer",
                "nombre" => "required|string",
                "apellidos" => "required|string",
                "acceso" => "required|string",
                "secreto" => "required|string",
                "estado" => "required|boolean"
            ]);

            $validado["secreto"] = password_hash($validado["secreto"], PASSWORD_DEFAULT);
            $usuario = Usuario::find($request["id_usuario"]);
            if ($usuario) {
                $usuario->update($validado);
            };

            return response()->json(0, 404);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage(), 500);
        }
    }

    public function eliminar($id): JsonResponse
    {
        try {
            $usuario = Usuario::find($id);
            if ($usuario) {
                Usuario::destroy($id);
                return response()->json(1);
            }

            return response()->json(0, 404);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage(), 500);
        }
    }

    public function estado(Request $request): JsonResponse
    {
        try {
            $usuario["id_usuario"] = $request["id_usuario"];
            $usuario["estado"] = $request["estado"];

            Usuario::findOrFail($usuario["id_usuario"])->update($usuario);
            return response()->json(1);
        } catch (\Throwable $ex) {
            return response()->json($ex->getMessage(), 500);
        }
    }
}
