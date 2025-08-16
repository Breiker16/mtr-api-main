<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    public $timestamps = false;

    // Nombre exacto de tu tabla
    protected $table = "tbl_tarea";

    // Clave primaria correcta
    protected $primaryKey = "id_tarea";

    protected $fillable = [
        "nombre",       // Cambiado de "titulo" a "nombre" (como en tu BD)
        "descripcion",
        "hora_inicio",  // Cambiado de "fecha_inicio" (time en BD)
        "hora_fin",     // Cambiado de "fecha_fin" (time en BD)
        "estado"        // Cambiado de "estado_orden_id" (boolean en BD)
        // Se eliminó "empleado_id" (no existe relación directa en tu BD)
    ];

    // Relación con orden_trabajo_linea (en lugar de empleado directo)
    public function ordenTrabajoLinea()
    {
        return $this->hasOne(OrdenTrabajoLinea::class, 'id_tarea', 'id_tarea');
    }
}
