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
        Schema::table('Tarea', function (Blueprint $table) {
            $table->unsignedBigInteger('id_usuario_creador')->nullable();
            $table->unsignedBigInteger('id_usuario_asignado')->nullable();
            
            $table->foreign('id_usuario_creador')->references('id')->on('Usuario');
            $table->foreign('id_usuario_asignado')->references('id')->on('Usuario');
        });
        
        // Copiar datos existentes de id_usuario a id_usuario_creador
        DB::statement('UPDATE [Tarea] SET [id_usuario_creador] = [id_usuario] WHERE [id_usuario] IS NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Tarea', function (Blueprint $table) {
            $table->dropForeign(['id_usuario_creador']);
            $table->dropForeign(['id_usuario_asignado']);
            $table->dropColumn(['id_usuario_creador', 'id_usuario_asignado']);
        });
    }
};
