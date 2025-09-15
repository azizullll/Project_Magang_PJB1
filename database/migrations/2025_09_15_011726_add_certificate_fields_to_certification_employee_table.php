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
            $table->string('certificate_image')->nullable()->after('certification_id');
            $table->date('expiration_date')->nullable()->after('certificate_image');
            $table->date('issued_date')->nullable()->after('expiration_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certification_employee', function (Blueprint $table) {
            $table->dropColumn(['certificate_image', 'expiration_date', 'issued_date']);
        });
    }
};
