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
        Schema::create('guest_sessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ip_address');
            $table->string('device_hash');
            $table->string('os_type')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('last_activity')->useCurrent();
            $table->enum('status', ['guest', 'logged_in', 'session_ended'])->default('guest');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_sessions');
    }
};
