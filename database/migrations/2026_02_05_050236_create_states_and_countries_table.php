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
        // Create countries table first
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('iso_code', 2)->unique();
            $table->string('iso3', 3)->nullable();
            $table->string('phone_code')->nullable();
            $table->string('currency_code', 3)->nullable();
            $table->string('currency_name')->nullable();
            $table->string('continent')->nullable();
            $table->string('flag')->nullable();
            $table->timestamps();
        });

        // Create states table next
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_id'); // reference to countries
            $table->string('country_code')->nullable();
            $table->string('name'); // state/province name
            $table->string('iso_code')->nullable(); // optional code
            $table->timestamps();

            $table->foreign('country_id')
                  ->references('id')
                  ->on('countries')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop states first because it references countries
        Schema::dropIfExists('states');
        Schema::dropIfExists('countries');
    }
};