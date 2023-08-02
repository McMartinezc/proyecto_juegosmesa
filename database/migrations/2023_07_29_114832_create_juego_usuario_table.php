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
        Schema::create('juego_usuario', function (Blueprint $table) {
            $table->unsignedBigInteger('idjuego');
            $table->unsignedBigInteger('idusuario');
            $table->boolean('privado')->default(true);

            $table->foreign('idjuego')->references('idjuego')->on('juegos')->onDelete('cascade');
            $table->foreign('idusuario')->references('idusuario')->on('usuarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('juego_usuario', function (Blueprint $table) {
            //
        });
    }
};
