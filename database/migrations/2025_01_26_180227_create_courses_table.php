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
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignIdFor(\App\Models\Category::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Teacher::class)->nullable()->constrained()->onDelete('cascade');
            $table->text('title')->nullable();
            $table->text('intro_video')->nullable();
            $table->text('intro_video_thumbnail')->nullable();
            $table->longText('description')->nullable();
            $table->longText('requirements')->nullable();
            $table->longText('what_will_you_learn')->nullable();
            $table->longText('who_this_course_is_for')->nullable();
            $table->string('language')->nullable();
            $table->double('price')->nullable();
            $table->double('after_discount_price')->nullable();
            $table->string('discount')->nullable();
            $table->boolean('task_included')->default(0);
            $table->integer('certificate')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
