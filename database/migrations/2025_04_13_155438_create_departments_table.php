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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->enum('type', ['user', 'department'])->default('user');

            $table->unsignedBigInteger('creator_id')->nullable(); 
            $table->foreign('creator_id')->references('id')->on('users');

            $table->unsignedBigInteger('department_id')->nullable(); 
            $table->foreign('department_id')->references('id')->on('departments');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedTinyInteger('progress')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
