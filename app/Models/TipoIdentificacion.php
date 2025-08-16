<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoIdentificacion extends Model
{
    // Desactivo los timestamps ya que mi tabla no tiene created_at ni updated_at
    public $timestamps = false;

    // Especifico el nombre exacto de la tabla en la BD
    protected $table = "tbl_tipo_identificacion";

    // Defino la llave primaria como está en mi tabla
    protected $primaryKey = "id_tipo_identificacion";

    // Solo incluyo el campo 'nombre' porque es el único campo llenable en mi tabla
    // No incluyo la PK (id_tipo_identificacion) porque es autoincremental
    // Tampoco incluyo 'mascara' porque no existe en mi estructura de BD
    protected $fillable = [
        "nombre"
    ];

    // No necesito relaciones aquí porque:
    // 1. La relación con Empleado ya está definida en el modelo Empleado
    // 2. Esta es una tabla maestra simple
}
