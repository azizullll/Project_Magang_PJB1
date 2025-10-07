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
        Schema::table('certification_employee', function (Blueprint $table) {
            $table->string('certificate_file')->nullable()->after('issued_date'); // pdf/image path
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certification_employee', function (Blueprint $table) {
            $table->dropColumn('certificate_file');
        });
    }
};
