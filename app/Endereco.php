<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $fillable = ['cep' ,'endereco', 'cidade', 'uf', 'numero', 'bairro', 'complemento', 'ponto_referencia', 'id_user', 'cadastradoPorUsuario', 'alteradoPorUsuario', 'inativadoPorUsuario', 'motivoInativado', 'dataInativado','ativo'];

    protected $guarded = ['id', 'created_at', 'update_at'];

    protected $table = 'enderecos';

    const ATIVO = true;
    const INATIVO = false;

    public function cad_usuario()
    {
        return $this->belongsTo(User::class, 'cadastradoPorUsuario');
    }
    public function cadastradoPor()
    {
        return $this->belongsTo(User::class, 'cadastradoPorUsuario');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function setCepAttribute($value)
    {
        $this->attributes['cep'] = preg_replace('/[^0-9]/', '', $value);
    }
}
