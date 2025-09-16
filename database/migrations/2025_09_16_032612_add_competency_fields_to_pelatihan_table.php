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
        Schema::table('pelatihan', function (Blueprint $table) {
            $table->text('kompetensi_inti')->nullable()->after('tenggat_sertifikat');
            $table->text('kompetensi_pilihan')->nullable()->after('kompetensi_inti');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelatihan', function (Blueprint $table) {
            $table->dropColumn(['kompetensi_inti', 'kompetensi_pilihan']);
        });
    }
};
