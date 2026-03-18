<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('contact_settings', 'whatsapp_message')) {
                $table->text('whatsapp_message')->nullable()->after('whatsapp');
            }
            if (!Schema::hasColumn('contact_settings', 'latitude')) {
                $table->string('latitude', 30)->nullable()->after('map_embed');
            }
            if (!Schema::hasColumn('contact_settings', 'longitude')) {
                $table->string('longitude', 30)->nullable()->after('latitude');
            }
        });
    }

    public function down(): void
    {
        Schema::table('contact_settings', function (Blueprint $table) {
            $table->dropColumn(['whatsapp_message', 'latitude', 'longitude']);
        });
    }
};
