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
        // First, drop the foreign keys if they were added
        Schema::table('resources', function (Blueprint $table) {
            // Convert id_typeressource and id_cat to bigInteger to match FK tables
            $table->bigInteger('id_typeressource')->change();
            $table->bigInteger('id_cat')->change();
        });
    }

    public function down(): void
    {
        Schema::table('resources', function (Blueprint $table) {
            // Revert back to original types if needed
            $table->unsignedBigInteger('id_typeressource')->change();
            $table->unsignedBigInteger('id_cat')->change();
        });
    }
};
