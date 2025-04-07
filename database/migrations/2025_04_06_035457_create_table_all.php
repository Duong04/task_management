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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('value');
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('permission_actions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('action_id');
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->foreign('action_id')->references('id')->on('actions')->onDelete('cascade');
        });

        // Bảng 'role_permissions'
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('action_id');
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->foreign('action_id')->references('id')->on('actions')->onDelete('cascade');
        });

        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); 
            $table->string('décription')->unique(); 
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('avatar')->nullable()->default('https://res.cloudinary.com/dsdyprt1q/image/upload/v1726997687/CLINIC/avatars/kcopet60brdlxcpybxjw.png');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_active')->default(false)->nullable();
            $table->unsignedBigInteger('role_id');

            $table->foreign('role_id')->references('id')->on('roles');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('employee_code')->unique();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable(); 
            $table->unsignedBigInteger('position_id')->nullable();

            $table->foreign('position_id')->references('id')->on('positions');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
        

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->text('description')->nullable(); 
            $table->enum('status', ['not_started', 'in_progress', 'completed'])->nullable()->default('not_started');; 
            $table->date('start_date')->nullable(); 
            $table->date('end_date')->nullable(); 
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('task_code')->unique(); 
            $table->text('description')->nullable(); 
            $table->date('start_date')->nullable(); 
            $table->date('end_date')->nullable(); 
            $table->enum('status', ['not_started', 'in_progress', 'completed'])->default('not_started'); 
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('low'); 
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('assigned_to'); 
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('subtasks', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->text('description')->nullable();
            $table->date('due_date')->nullable(); 
            $table->enum('status', ['not_started', 'in_progress', 'completed'])->default('not_started');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('low'); 
            $table->unsignedBigInteger('task_id'); 
            $table->unsignedBigInteger('assigned_to'); 
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('discussions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); 
            $table->text('message'); 
            $table->morphs('discussionable'); 
            $table->timestamps();
        });

        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('file_path');
            $table->text('description')->nullable();
            $table->morphs('attachable');
            $table->timestamps();
        });

        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('title'); 
            $table->text('report_data'); 
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->date('report_date')->nullable(); 
            $table->morphs('attachable');
            $table->unsignedBigInteger('created_by'); 
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
