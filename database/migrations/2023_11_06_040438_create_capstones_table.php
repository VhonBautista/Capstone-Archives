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
        Schema::create('capstones', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->string('title');
            $table->text('description');
            $table->string('authors');
            $table->string('panels');
            $table->string('adviser');
            $table->date('year_published');
            $table->string('pdf_name')->nullable();
            $table->enum('type', ['web', 'mobile', 'desktop', 'game', 'pos', 'others']);
            $table->integer('view_count')->default(0);
            $table->integer('saved_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capstones');
    }
};
