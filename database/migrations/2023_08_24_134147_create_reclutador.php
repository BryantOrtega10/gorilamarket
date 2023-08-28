<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reclutador', function (Blueprint $table) {
            $table->id("id_reclutador");
            $table->string("cedula", 20);
            $table->string("nombre", 50);
            $table->string("apellido", 50);
            $table->string("email", 100);
            $table->string("celular", 20);
            $table->tinyInteger("estado")->comment("0 inactivo, 1 activo")->default(1);
            $table->integer("valor_recaudado")->default(0);
            $table->integer("valor_pagado")->default(0);
            $table->bigInteger("fk_usuario",false, true);
            $table->foreign("fk_usuario")->references("id")->on("users")->onDelete("cascade");
            $table->timestamps();
        });
        Schema::table('cliente', function (Blueprint $table) {
            $table->bigInteger("fk_reclutador",false,true)->nullable();
            $table->foreign("fk_reclutador")->references("id_reclutador")->on("reclutador")->onDelete("set null");
        });   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cliente', function (Blueprint $table) {
            $table->dropForeign('cliente_fk_reclutador_foreign');
            $table->dropIndex('cliente_fk_reclutador_foreign');
            $table->dropColumn("fk_reclutador");

        });   
        Schema::table('reclutador', function (Blueprint $table) {
            $table->dropForeign('reclutador_fk_usuario_foreign');
            $table->dropIndex('reclutador_fk_usuario_foreign');
        });

        Schema::dropIfExists('reclutador');
    }
};
