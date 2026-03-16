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
        Schema::table('resources', function (Blueprint $table) {
            // Add user_id foreign key
            $table->unsignedBigInteger('user_id')->nullable()->after('id_ressource');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('resources', function (Blueprint $table) {
            // Drop foreign keys
            $table->dropForeignKey('resources_user_id_foreign');
            
            // Drop user_id column
            $table->dropColumn('user_id');
        });
    }
};
