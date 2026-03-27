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
        Schema::table('home_settings', function (Blueprint $table) {
            $table->string('stat_1_number')->nullable();
            $table->string('stat_1_label')->nullable();
            $table->string('stat_2_number')->nullable();
            $table->string('stat_2_label')->nullable();
            $table->string('stat_3_number')->nullable();
            $table->string('stat_3_label')->nullable();
            $table->string('stat_4_number')->nullable();
            $table->string('stat_4_label')->nullable();
            $table->text('showreel_video_url')->nullable();
            $table->string('showreel_title')->nullable();
            $table->text('showreel_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->dropColumn([
                'stat_1_number', 'stat_1_label',
                'stat_2_number', 'stat_2_label',
                'stat_3_number', 'stat_3_label',
                'stat_4_number', 'stat_4_label',
                'showreel_video_url', 'showreel_title', 'showreel_description'
            ]);
        });
    }
};
