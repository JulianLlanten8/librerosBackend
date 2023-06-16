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
        Schema::create(
            'libros',
            function (Blueprint $table) {
                $table->id();
                $table->string('titulo');
                $table->string('autor');
                $table->text('descripcion');
                $table->string('genero');
                $table->string('fecha_publicacion');
                $table->string('isbn');
                $table->string('editorial');
                $table->string('portada')->nullable();
                $table->timestamps();
                $table->softDeletes();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libros');
    }
};
