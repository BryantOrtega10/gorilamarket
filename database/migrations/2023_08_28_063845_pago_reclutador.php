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
        Schema::create('pago_reclutador', function (Blueprint $table) {
            $table->bigInteger("fk_reclutador",false, true);
            $table->foreign("fk_reclutador")->references("id_reclutador")->on("reclutador")->onDelete("cascade");
            $table->integer("num_pago",false, true);            
            $table->integer("valor_pagado")->default(0);
            $table->timestamps();
            $table->primary(["fk_reclutador","num_pago"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pago_reclutador', function (Blueprint $table) {
            $table->dropForeign('pago_reclutador_fk_reclutador_foreign');
            $table->dropIndex('pago_reclutador_fk_reclutador_foreign');
        });
        Schema::dropIfExists('pago_reclutador');
    }
};
