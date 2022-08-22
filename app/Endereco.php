<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $fillable = ['nome', 'cpf', 'email', 'telefone','cep' ,'endereco', 'cidade', 'uf', 'numero', 'bairro', 'complemento', 'ponto_referencia', 'lat', 'long','id_user', 'cadastradoPorUsuario', 'alteradoPorUsuario', 'inativadoPorUsuario', 'motivoInativado', 'dataInativado','ativo'];

    protected $guarded = ['id', 'created_at', 'update_at'];

    protected $table = 'enderecos';

    public function cad_usuario()
    {
        return $this->belongsTo(User::class, 'cadastradoPorUsuario');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'cadastradoPorUsuario');
    }
}
