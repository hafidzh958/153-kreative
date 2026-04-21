<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('fin_budgets', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->string('client_name')->nullable();
            $table->decimal('total_budget', 15, 2)->default(0);
            $table->decimal('venue_budget', 15, 2)->default(0);
            $table->decimal('fb_budget', 15, 2)->default(0);
            $table->decimal('talent_budget', 15, 2)->default(0);
            $table->decimal('transport_budget', 15, 2)->default(0);
            $table->decimal('marketing_budget', 15, 2)->default(0);
            $table->decimal('other_budget', 15, 2)->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['active','completed','over_budget'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('fin_budgets');
    }
};
