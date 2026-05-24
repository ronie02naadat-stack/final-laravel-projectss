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
        Schema::table('users', function (Blueprint $table) {
            $table->string('specialization')->nullable()->comment('Teacher subject/specialization');
            $table->integer('experience_years')->nullable()->default(0)->comment('Years of teaching experience');
            $table->string('office_location')->nullable()->comment('Office room or location');
            $table->string('contact_number')->nullable()->comment('Contact number for teacher');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['specialization', 'experience_years', 'office_location', 'contact_number']);
        });
    }
};
