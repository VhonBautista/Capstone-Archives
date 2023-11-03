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
            $table->foreignId('user_id')->constrained('users');
            $table->boolean('manage_request')->default(0);
            $table->boolean('manage_create')->default(0);
            $table->boolean('manage_update')->default(0);
            $table->boolean('manage_delete')->default(0);
            $table->boolean('manage_approval')->default(0);
            $table->boolean('manage_user')->default(0);
            $table->boolean('manage_permission')->default(0);
            $table->boolean('manage_verification')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
