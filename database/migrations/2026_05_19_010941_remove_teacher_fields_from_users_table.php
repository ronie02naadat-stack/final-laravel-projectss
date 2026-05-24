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
            $table->dropColumn(['specialization', 'experience_years', 'office_location', 'contact_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('specialization')->nullable();
            $table->integer('experience_years')->nullable()->default(0);
            $table->string('office_location')->nullable();
            $table->string('contact_number')->nullable();
        });
    }
};
