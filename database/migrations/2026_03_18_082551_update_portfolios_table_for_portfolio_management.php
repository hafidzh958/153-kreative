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
        Schema::table('portfolios', function (Blueprint $table) {
            // Drop gracefully if columns exist
            if (Schema::hasColumn('portfolios', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('portfolios', 'client')) {
                $table->dropColumn('client');
            }
            if (Schema::hasColumn('portfolios', 'event_date')) {
                $table->dropColumn('event_date');
            }
            // Add new columns. First check if they exist to be safe since it failed previously.
            if (!Schema::hasColumn('portfolios', 'category_id')) {
                $table->foreignId('category_id')->nullable()->constrained('portfolio_categories')->nullOnDelete();
            }
            if (!Schema::hasColumn('portfolios', 'is_featured')) {
                $table->boolean('is_featured')->default(false);
            }
            if (!Schema::hasColumn('portfolios', 'order')) {
                $table->unsignedInteger('order')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['category_id', 'is_featured', 'order']);
            $table->text('description')->nullable();
            $table->string('client')->nullable();
            $table->date('event_date')->nullable();
        });
    }
};
