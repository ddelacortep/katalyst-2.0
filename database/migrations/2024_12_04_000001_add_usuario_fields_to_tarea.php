<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('Tarea', function (Blueprint $table) {
            // Verificar si las columnas no existen antes de crearlas
            if (!Schema::hasColumn('Tarea', 'id_usuario_creador')) {
                $table->unsignedBigInteger('id_usuario_creador')->nullable();
            }
            if (!Schema::hasColumn('Tarea', 'id_usuario_asignado')) {
                $table->unsignedBigInteger('id_usuario_asignado')->nullable();
            }
        });
        
        // Agregar las claves foráneas solo si no existen
        Schema::table('Tarea', function (Blueprint $table) {
            try {
                $table->foreign('id_usuario_creador')->references('id')->on('Usuario');
            } catch (\Exception $e) {
                // La clave foránea ya existe
            }
            
            try {
                $table->foreign('id_usuario_asignado')->references('id')->on('Usuario');
            } catch (\Exception $e) {
                // La clave foránea ya existe
            }
        });
        
        // Copiar datos existentes de id_usuario a id_usuario_creador (solo si existe la columna id_usuario)
        try {
            if (Schema::hasColumn('Tarea', 'id_usuario')) {
                DB::statement('UPDATE [Tarea] SET [id_usuario_creador] = [id_usuario] WHERE [id_usuario] IS NOT NULL AND [id_usuario_creador] IS NULL');
            }
        } catch (\Exception $e) {
            // La columna id_usuario no existe o hay otro problema, continuar sin error
        }
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
