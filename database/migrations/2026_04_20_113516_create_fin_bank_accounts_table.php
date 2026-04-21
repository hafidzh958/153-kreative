<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('fin_bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_name');
            $table->string('bank_name');
            $table->string('account_number');
            $table->enum('currency', ['IDR','USD','SGD','EUR'])->default('IDR');
            $table->decimal('current_balance', 18, 2)->default(0);
            $table->enum('type', ['main','operational','foreign','savings'])->default('main');
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('fin_bank_mutations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_account_id')->constrained('fin_bank_accounts')->onDelete('cascade');
            $table->string('description');
            $table->string('reference_number')->nullable();
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('credit', 15, 2)->default(0);
            $table->decimal('balance_after', 18, 2)->default(0);
            $table->date('date');
            $table->enum('mutation_type', ['in','out'])->default('in');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('fin_bank_mutations');
        Schema::dropIfExists('fin_bank_accounts');
    }
};
