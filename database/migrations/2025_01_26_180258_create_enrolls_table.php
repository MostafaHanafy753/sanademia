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
        Schema::create('enrolls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->ForeignIdFor(\App\Models\Course::class)->nullable()->constrained()->onDelete('cascade');
            $table->ForeignIdFor(\App\Models\User::class)->nullable()->constrained()->onDelete('cascade');
            $table->ForeignIdFor(\App\Models\PaymentType::class)->nullable()->constrained()->onDelete('cascade');
            $table->string('payment_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrolls');
    }
};
