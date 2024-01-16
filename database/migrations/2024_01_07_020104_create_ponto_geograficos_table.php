<?php

use App\PontoGeografico;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePontoGeograficosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ponto_geograficos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->bigInteger('id_endereco')->unsigned()->nullable();
            $table->foreign('id_endereco')->references('id')->on('enderecos');
            $table->uuid('id_user')->unsigned()->nullable();
            $table->foreign('id_user')->references('id')->on('users');
            $table->uuid('cadastradoPorUsuario')->unsigned()->nullable();
            $table->foreign('cadastradoPorUsuario')->references('id')->on('users');
            $table->uuid('alteradoPorUsuario')->unsigned()->nullable();
            $table->foreign('alteradoPorUsuario')->references('id')->on('users');
            $table->uuid('inativadoPorUsuario')->unsigned()->nullable();
            $table->foreign('inativadoPorUsuario')->references('id')->on('users');
            $table->date('dataInativado')->nullable();
            $table->text('motivoInativado')->nullable();
            $table->boolean('ativo')->default(PontoGeografico::ATIVO);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ponto_geograficos');
    }
}
