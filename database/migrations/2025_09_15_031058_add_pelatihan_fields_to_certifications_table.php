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
        Schema::table('certifications', function (Blueprint $table) {
            $table->string('bidang')->nullable()->after('name');
            $table->string('judul')->nullable()->after('bidang');
            $table->text('kompetensi_inti')->nullable()->after('judul');
            $table->text('kompetensi_pilihan')->nullable()->after('kompetensi_inti');
            $table->integer('level')->nullable()->after('kompetensi_pilihan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certifications', function (Blueprint $table) {
            $table->dropColumn(['bidang', 'judul', 'kompetensi_inti', 'kompetensi_pilihan', 'level']);
        });
    }
};
