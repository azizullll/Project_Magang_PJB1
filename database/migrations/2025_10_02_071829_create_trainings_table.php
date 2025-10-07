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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('category'); // Teknis, Manajerial, K3, Softskill
            $table->json('relevant_divisions'); // Array of division IDs
            $table->json('relevant_job_positions'); // Array of job position IDs
            $table->integer('level'); // 1-7
            $table->decimal('cost', 15, 2)->nullable();
            $table->integer('duration_hours')->nullable();
            $table->integer('duration_days')->nullable();
            $table->string('institution')->nullable();
            $table->string('certification_code')->nullable();
            $table->text('competencies_gained')->nullable();
            $table->text('next_competencies')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};
