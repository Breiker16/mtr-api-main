<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoOrden extends Model
{
    public $timestamps = false;

    // Nombre exacto de tu tabla
    protected $table = "tbl_estado_orden";

    // Clave primaria correcta
    protected $primaryKey = "id_estado_orden";

    protected $fillable = [
        "nombre"  // Solo este campo existe en tu BD
        // Se eliminó "descripcion" que no existe en tu tabla
    ];

    // Relación corregida con órdenes de trabajo (no con tareas)
    public function ordenesTrabajo()
    {
        return $this->hasMany(OrdenTrabajo::class, "id_estado_orden", "id_estado_orden");
    }
}
