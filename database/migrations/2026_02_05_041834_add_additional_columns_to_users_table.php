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
            $table->boolean('access_level_master')->default(false);
            $table->integer('access_level')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('nationality')->nullable();
            $table->string('marital_status')->nullable();
            $table->boolean('is_active')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['access_level_master','access_level','first_name','last_name','gender','date_of_birth','phone_number','nationality','marital_status','is_active']);
        });
    }
};
