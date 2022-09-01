<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anexo extends Model
{
    protected $fillable = ['nome_original', 'nome_hash', 'descricao', 'arquivo', 'cadastradoPorUsuario', 'alteradoPorUsuario', 'inativadoPorUsuario', 'motivoInativado', 'dataInativado','ativo'];

    protected $guarded = ['id', 'created_at', 'update_at'];

    protected $table = 'anexos';

    public function cad_usuario()
    {
        return $this->belongsTo(User::class, 'cadastradoPorUsuario');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'cadastradoPorUsuario');
    }

}
