<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    public $timestamps = false;

    // Ajustar nombre de tabla para coincidir con tu BD
    protected $table = "tbl_empleado";

    // Ajustar clave primaria
    protected $primaryKey = "id_empleado";

    protected $fillable = [
        "nombre",
        "apellidos", // Cambiado a plural (como en tu BD)
        "correo",
        "telefono",
        "id_tipo_identificacion", // Nombre correcto de FK
        "identificacion", // Cambiado de numero_identificacion
        "direccion", // Campos adicionales de tu BD
        "puesto",
        "estado"
    ];

    // Relación ajustada
    public function tipoIdentificacion()
    {
        return $this->belongsTo(TipoIdentificacion::class, "id_tipo_identificacion", "id_tipo_identificacion");
    }

    // Relación con órdenes de trabajo (no directa con tareas)
    public function ordenesTrabajo()
    {
        return $this->hasMany(OrdenTrabajo::class, "id_empleado", "id_empleado");
    }
}
