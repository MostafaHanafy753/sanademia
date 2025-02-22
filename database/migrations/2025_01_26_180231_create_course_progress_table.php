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
        Schema::create('course_progress', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignIdFor(\App\Models\User::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Course::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\CourseContent::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Lecture::class)->nullable()->constrained()->onDelete('cascade');
            $table->string('completed_minute')->nullable();
            $table->string('remaining_minute')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_progress');
    }
};
