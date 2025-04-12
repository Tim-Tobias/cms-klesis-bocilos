<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE images MODIFY category ENUM('home-section','about-section','story-section','team-section','signature-section','menu-section','today-menu-section','footer-section', 'gallery-section') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE images MODIFY category ENUM('home-section','about-section','story-section','team-section','signature-section','menu-section','today-menu-section','footer-section') NOT NULL");
    }
};
