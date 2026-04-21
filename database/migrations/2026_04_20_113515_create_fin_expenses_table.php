<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('fin_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->enum('category', ['venue','fb','transport','talent','marketing','admin','other'])->default('other');
            $table->string('event_name')->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            $table->date('date');
            $table->string('receipt_path')->nullable();
            $table->boolean('reimbursable')->default(false);
            $table->string('employee_name')->nullable();
            $table->enum('reimbursement_status', ['none','pending','approved','paid'])->default('none');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('fin_expenses');
    }
};
