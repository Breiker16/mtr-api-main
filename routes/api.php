<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\TipoIdentificacionController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

// Ruta pública (sin token)
Route::prefix("auth")->group(function () {
    Route::post("login", [AuthController::class, "login"]);
});

// Rutas protegidas (requieren token)
Route::middleware('auth:api')->group(function () {
    Route::prefix("auth")->group(function () {
        Route::post("logout", [AuthController::class, "logout"]);
        Route::get("me", [AuthController::class, "me"]);
        Route::post("refresh", [AuthController::class, "refresh"]);
    });

    // Grupo de rutas para tipo de identificación.
    Route::prefix('tipo-identificacion')->group(function () {
        Route::get('listar', [TipoIdentificacionController::class, 'listar']);
        Route::get('consultar/{id}', [TipoIdentificacionController::class, 'consultar']);
        Route::post('guardar', [TipoIdentificacionController::class, 'guardar']);
        Route::put('actualizar', [TipoIdentificacionController::class, 'actualizar']);
        Route::delete('eliminar/{id}', [TipoIdentificacionController::class, 'eliminar']);
    });

    // Grupo de rutas para estudiante.
    Route::prefix('estudiante')->group(function () {
        Route::get('listar', [EstudianteController::class, 'listar']);
        Route::get('consultar/{id}', [EstudianteController::class, 'consultar']);
        Route::post('guardar', [EstudianteController::class, 'guardar']);
        Route::put('actualizar', [EstudianteController::class, 'actualizar']);
        Route::patch('estado', [EstudianteController::class, 'estado']);
    });

    // Grupo de rutas para profesor.
    Route::prefix('profesor')->group(function () {
        Route::get('listar', [ProfesorController::class, 'listar']);
        Route::get('consultar/{id}', [ProfesorController::class, 'consultar']);
        Route::post('guardar', [ProfesorController::class, 'guardar']);
        Route::put('actualizar', [ProfesorController::class, 'actualizar']);
        Route::patch('estado', [ProfesorController::class, 'estado']);
    });

    // Grupo de rutas para curso.
    Route::prefix('curso')->group(function () {
        Route::get('listar', [CursoController::class, 'listar']);
        Route::get('consultar/{id}', [CursoController::class, 'consultar']);
        Route::post('guardar', [CursoController::class, 'guardar']);
        Route::put('actualizar', [CursoController::class, 'actualizar']);
        Route::patch('estado', [CursoController::class, 'estado']);
        Route::post("reporte-cursos", [CursoController::class, "reporteCurso"]);
    });

    // Grupo de rutas para matrícula.
    Route::prefix('matricula')->group(function () {
        Route::get('listar', [MatriculaController::class, 'listar']);
        Route::get('consultar/{id}', [MatriculaController::class, 'consultar']);
        Route::post('guardar', [MatriculaController::class, 'guardar']);
        //Route::put('actualizar', [MatriculaController::class, 'actualizar']);
        Route::patch('estado', [MatriculaController::class, 'estado']);
        Route::post("reporte-fechas", [MatriculaController::class, "reporteMatricula"]);
    });

    // Grupo de rutas para usuario.
    Route::prefix('usuario')->group(function () {
        Route::get('listar', [UsuarioController::class, 'listar']);
        Route::get('consultar/{id}', [UsuarioController::class, 'consultar']);
        Route::post('guardar', [UsuarioController::class, 'guardar']);
        Route::put('actualizar', [UsuarioController::class, 'actualizar']);
        Route::patch('estado', [UsuarioController::class, 'estado']);;
    });
});
