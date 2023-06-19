<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\UserType;
use App\Enums\UserRole;
use App\Enums\UserCourse;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('course', UserCourse::getValues())->nullable();
            $table->unsignedInteger('enrollment_number')->nullable();
            $table->string('cellphone', 15)->nullable();
            $table->enum('role', UserRole::getValues())->default(UserRole::Requester->value);
            $table->enum('type', UserType::getValues())->default(UserType::Student->value);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
