<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $fillable = ['cep' ,'endereco', 'cidade', 'uf', 'numero', 'bairro', 'complemento', 'ponto_referencia', 'id_user', 'cadastradoPorUsuario', 'alteradoPorUsuario', 'ativo'];

    protected $guarded = ['id', 'created_at', 'update_at'];

    protected $table = 'enderecos';

    public function cad_usuario()
    {
        return $this->belongsTo(User::class, 'cadastradoPorUsuario');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
