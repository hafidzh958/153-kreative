<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('fin_invoices', function (Blueprint $table) {
            $table->string('product_type')->nullable()->after('client_phone');      // Jenis/Merk Product
            $table->text('client_address')->nullable()->after('product_type');      // Alamat lengkap kantor
            $table->string('client_pic')->nullable()->after('client_address');      // Penanggungjawab
            $table->string('event_date_start')->nullable()->after('event_name');    // Tanggal event mulai (free text "17 April 2026")
            $table->string('event_date_end')->nullable()->after('event_date_start');// Tanggal event selesai
            $table->string('venue')->nullable()->after('event_date_end');           // Venue / lokasi event
            $table->string('space')->nullable()->after('venue');                    // Ukuran space (3m x 5m = 15m2)
            $table->boolean('is_non_tax')->default(false)->after('tax_rate');      // NON TAX flag
            $table->string('ref_quotation')->nullable()->after('bank_account');     // No. Surat Penawaran referensi
        });
    }

    public function down(): void {
        Schema::table('fin_invoices', function (Blueprint $table) {
            $table->dropColumn(['product_type','client_address','client_pic',
                'event_date_start','event_date_end','venue','space','is_non_tax','ref_quotation']);
        });
    }
};
