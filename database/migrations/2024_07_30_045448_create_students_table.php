<?php

use App\Models\Department;
use App\Models\User;
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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('student_code')->nullable()->unique();
            $table->string('avatar')->nullable();
            $table->string('phone', 20)->nullable()->unique();
            $table->unsignedTinyInteger('status')->default(0);
            $table->string('address')->nullable();
            $table->boolean('gender')->default(0);
            $table->date('birthday')->nullable();
            $table->foreignIdFor(Department::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
