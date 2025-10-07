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
        Schema::table('trainings', function (Blueprint $table) {
            // Drop duration_hours column
            if (Schema::hasColumn('trainings', 'duration_hours')) {
                $table->dropColumn('duration_hours');
            }
            // Add certificate active years
            $table->integer('certificate_active_years')->nullable()->after('level');
            // Add institution contact details
            $table->string('institution_phone', 50)->nullable()->after('institution');
            $table->string('institution_email', 150)->nullable()->after('institution_phone');
            $table->string('institution_address', 255)->nullable()->after('institution_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            // Re-add duration_hours
            $table->integer('duration_hours')->nullable()->after('cost');
            // Drop new columns
            $table->dropColumn(['certificate_active_years', 'institution_phone', 'institution_email', 'institution_address']);
        });
    }
};
