<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('fin_commissions', function (Blueprint $table) {
            $table->id();
            $table->string('employee_name');
            $table->string('employee_division')->nullable();
            $table->string('event_name')->nullable();
            $table->decimal('revenue_amount', 15, 2)->default(0);
            $table->decimal('rate', 5, 2)->default(5);
            $table->decimal('commission_amount', 15, 2)->default(0);
            $table->enum('type', ['sales','operation','bonus','incentive'])->default('sales');
            $table->enum('status', ['pending','approved','paid'])->default('pending');
            $table->date('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('fin_commissions');
    }
};
