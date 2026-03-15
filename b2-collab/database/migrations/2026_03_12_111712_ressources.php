<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id('id_ressource');          // Clé primaire
            $table->string('name_ressource');    // Nom de la ressource
            $table->text('description')->nullable(); //Description de la ressource
            $table->unsignedInteger('nb_visites')->default(0);            $table->dateTime('derniere_connexion')->nullable(); // Dernière connexion
            $table->timestamps();                // created_at et updated_at automatiques
            $table->softDeletes();               // deleted_at pour suppression soft
            $table->unsignedBigInteger('id_typeressource'); // FK type
            $table->unsignedBigInteger('id_cat');          // FK category
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
