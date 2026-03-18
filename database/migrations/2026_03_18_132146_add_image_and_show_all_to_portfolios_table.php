<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            if (!Schema::hasColumn('portfolios', 'image')) {
                $table->string('image')->nullable()->after('category_id');
            }
            if (!Schema::hasColumn('portfolios', 'is_show_in_all')) {
                $table->boolean('is_show_in_all')->default(true)->after('is_featured');
            }
        });
    }

    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            if (Schema::hasColumn('portfolios', 'image')) {
                $table->dropColumn('image');
            }
            if (Schema::hasColumn('portfolios', 'is_show_in_all')) {
                $table->dropColumn('is_show_in_all');
            }
        });
    }
};
