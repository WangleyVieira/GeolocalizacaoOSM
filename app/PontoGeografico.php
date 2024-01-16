<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PontoGeografico extends Model
{
    protected $fillable = ['latitude' ,'longitude', 'id_endereco', 'id_user', 'cadastradoPorUsuario', 'alteradoPorUsuario', 'inativadoPorUsuario', 'motivoInativado', 'dataInativado','ativo'];

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
    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'id_endereco');
    }
}
