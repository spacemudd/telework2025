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
        Schema::table('support_tickets', function (Blueprint $table) {
            // Drop the existing morphs columns
            $table->dropMorphs('supportable');
            
            // Add the new uuidMorphs columns
            $table->uuidMorphs('supportable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('support_tickets', function (Blueprint $table) {
            // Drop the uuid morphs columns
            $table->dropMorphs('supportable');
            
            // Add back the original morphs columns
            $table->morphs('supportable');
        });
    }
};
