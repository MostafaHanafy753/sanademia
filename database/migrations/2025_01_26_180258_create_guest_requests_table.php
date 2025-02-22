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
        Schema::create('guest_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignIdFor(\App\Models\GuestSession::class)->index()->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\User::class)->index()->nullable()->constrained()->onDelete('cascade');
            $table->string('endpoint');
            $table->string('method');
            $table->longText('request_data')->nullable();
            $table->timestamp('timestamp')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_requests');
    }
};
