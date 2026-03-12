<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('types_ressources', function (Blueprint $table) {
            $table->id('id_typeressource');     // clé primaire
            $table->string('name_typeressource'); // nom du type

            $table->timestamps();               // created_at / updated_at
            $table->softDeletes();              // deleted_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('types_ressources');
    }
};
