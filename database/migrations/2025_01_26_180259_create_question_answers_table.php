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
        Schema::create('question_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignIdFor(\App\Models\User::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Exam::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Question::class)->nullable()->constrained()->onDelete('cascade');
            $table->text('answer')->nullable();
            $table->integer('correct')->nullable();
            $table->integer('skip')->nullable();
            $table->string('time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_answers');
    }
};
