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
        Schema::create('participants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('phone_number')->unique();
            $table->string('gender');
            $table->string('birth_place');
            $table->string('birth_date');
            $table->string('district');
            $table->string('sub_district');
            $table->string('address');
            $table->string('last_education');
            $table->string('education_major');
            $table->string('id_ticket')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
