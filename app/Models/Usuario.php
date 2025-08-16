<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Authenticatable implements JWTSubject
{
    protected $table = "tbl_usuario";
    protected $primaryKey = "id_usuario";
    public $timestamps = false;

    protected $fillable = [
        "id_usuario",
        "nombre",
        "apellidos",
        "acceso", // El nombre de usuario
        "secreto", // El equivalente a la contraseña
        "estado"
    ];

    protected $hidden = ["secreto"];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // Para que Laravel sepa que la contraseña está en 'secreto'
    public function getAuthPassword()
    {
        return $this->secreto;
    }

    // Función requerida por Authenticatable
    public function getAuthIdentifierName()
    {
        return $this->primaryKey;
    }
}
