<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('fin_purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_number')->unique();
            $table->string('vendor_name');
            $table->string('vendor_contact')->nullable();
            $table->string('vendor_email')->nullable();
            $table->enum('category', ['venue','catering','av','decoration','transport','talent','marketing','other'])->default('other');
            $table->string('event_name')->nullable();
            $table->text('description')->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->date('date');
            $table->date('delivery_date')->nullable();
            $table->enum('status', ['pending','approved','partial','paid','rejected'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('fin_purchase_orders');
    }
};
