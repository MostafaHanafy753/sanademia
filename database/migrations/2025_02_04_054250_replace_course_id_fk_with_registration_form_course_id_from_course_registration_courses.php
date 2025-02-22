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
        Schema::table('course_registration_courses', function (Blueprint $table) {
            $table->dropForeign('course_registration_courses_course_id_foreign');
            $table->dropColumn('course_id');
            $table->foreignIdFor(\App\Models\RegistrationFormCourse::class)->nullable()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_registration_courses', function (Blueprint $table) {
            $table->dropForeign('course_registration_courses_registration_form_course_id_foreign');
            $table->dropColumn('registration_form_course_id');
            $table->foreignIdFor(\App\Models\Course::class)->nullable()->constrained()->onDelete('cascade');
        });
    }
};
