<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioToken extends Model
{
    protected $table = 'usuarios_tokens';

    protected $fillable = [
        'usuario_id',
        'token',
        'tipo',
        'expira_en',
        'revocado',
    ];

    public $timestamps = true;
}
