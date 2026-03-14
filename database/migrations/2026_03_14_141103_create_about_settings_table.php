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
        Schema::create('about_settings', function (Blueprint $table) {
            $table->id();

            // SECTION 1 - ABOUT HERO
            $table->string('hero_title')->default('Tentang 153 Kreatif');
            $table->string('hero_subtitle')->default('Integrated Event Solutions & Creative Production');

            // SECTION 2 - CERITA KAMI
            $table->string('story_title')->default('Cerita Kami');
            $table->text('story_description')->nullable();
            $table->string('story_image')->nullable();

            // SECTION 3 - VISI
            $table->text('vision_text')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_settings');
    }
};
