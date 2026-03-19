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
        // Skip FK constraints due to datatype mismatches
        // Relationships are handled at model level
    }

    public function down(): void
    {
        // No-op
    }
};
