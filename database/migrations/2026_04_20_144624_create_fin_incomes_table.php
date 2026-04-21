<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fin_incomes', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->decimal('amount', 15, 2);
            $table->date('date');
            $table->string('category')->default('other');
            $table->string('source')->nullable();        // dari mana (klien, event, dll)
            $table->string('event_name')->nullable();
            $table->string('reference')->nullable();     // no. referensi / kwitansi
            $table->string('payment_method')->default('transfer');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fin_incomes');
    }
};
