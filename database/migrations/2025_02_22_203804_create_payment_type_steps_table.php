<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::create('payment_type_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_type_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('default_value')->nullable();
            $table->boolean('is_fixed')->default(false);
            $table->boolean('is_required')->default(true);
            $table->enum('input_type', ['text', 'number', 'select', 'checkbox', 'radio']);
            $table->json('select_options')->nullable(); // JSON field for multiple select values
            $table->integer('order')->default(1);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('payment_type_steps');
    }
};
