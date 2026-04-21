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
        Schema::create('fin_projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->date('project_date');
            $table->decimal('capital_price', 15, 2)->default(0); // Harga Modal
            $table->decimal('selling_price', 15, 2)->default(0); // Harga Jual
            $table->enum('status', ['belum_mulai', 'berlangsung', 'selesai'])->default('belum_mulai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fin_projects');
    }
};
