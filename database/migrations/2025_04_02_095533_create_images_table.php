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
        Schema::create('images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('file_path');
            $table->text('description')->nullable();
            $table->boolean('highlight')->default(false);
            $table->enum('category', ['home-section', 'about-section', 'story-section', 'team-section', 'signature-section', 'menu-section', 'today-menu-section', 'footer-section']);
            $table->enum('type', ['image', 'background']);
            $table->integer('order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
