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
            if (!Schema::hasColumn('certifications', 'category')) {
                $table->string('category')->nullable()->after('name'); // Umum / Khusus
            }
            if (!Schema::hasColumn('certifications', 'divisi')) {
                $table->string('divisi')->nullable()->after('category');
            }
            if (!Schema::hasColumn('certifications', 'jabatan')) {
                $table->string('jabatan')->nullable()->after('divisi');
            }
            if (!Schema::hasColumn('certifications', 'level')) {
                $table->string('level')->nullable()->after('jabatan');
            }
            if (!Schema::hasColumn('certifications', 'biaya')) {
                $table->unsignedInteger('biaya')->nullable()->after('level');
            }
            if (!Schema::hasColumn('certifications', 'durasi_jam')) {
                $table->unsignedInteger('durasi_jam')->nullable()->after('biaya');
            }
            if (!Schema::hasColumn('certifications', 'sertifikat_diberikan')) {
                $table->string('sertifikat_diberikan')->nullable()->after('durasi_jam');
            }
            if (!Schema::hasColumn('certifications', 'masa_aktif_bulan')) {
                $table->unsignedInteger('masa_aktif_bulan')->nullable()->after('sertifikat_diberikan');
            }
            if (!Schema::hasColumn('certifications', 'kompetensi_inti')) {
                $table->text('kompetensi_inti')->nullable()->after('masa_aktif_bulan');
            }
            if (!Schema::hasColumn('certifications', 'kompetensi_pilihan')) {
                $table->text('kompetensi_pilihan')->nullable()->after('kompetensi_inti');
            }
            if (!Schema::hasColumn('certifications', 'lembaga')) {
                $table->string('lembaga')->nullable()->after('kompetensi_pilihan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certifications', function (Blueprint $table) {
            $table->dropColumn([
                'category',
                'divisi',
                'jabatan',
                'level',
                'biaya',
                'durasi_jam',
                'sertifikat_diberikan',
                'masa_aktif_bulan',
                'kompetensi_inti',
                'kompetensi_pilihan',
                'lembaga',
            ]);
        });
    }
};
