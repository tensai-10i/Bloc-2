<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category', function (Blueprint $table) {
            $table->id('id_cat');       // clé primaire
            $table->string('name_cat'); // nom catégorie

            $table->timestamps();       // created_at / updated_at
            $table->softDeletes();      // deleted_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category');
    }
};
