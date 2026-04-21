<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('fin_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('label')->nullable();
            $table->string('group')->default('general');
            $table->timestamps();
        });

        // Default settings
        DB::table('fin_settings')->insert([
            ['key'=>'invoice_prefix','value'=>'INV','label'=>'Prefix Invoice','group'=>'invoice'],
            ['key'=>'invoice_next_number','value'=>'1','label'=>'Nomor Urut Invoice Berikutnya','group'=>'invoice'],
            ['key'=>'quotation_prefix','value'=>'QUO','label'=>'Prefix Quotation','group'=>'quotation'],
            ['key'=>'quotation_next_number','value'=>'1','label'=>'Nomor Urut Quotation Berikutnya','group'=>'quotation'],
            ['key'=>'po_prefix','value'=>'PO','label'=>'Prefix Purchase Order','group'=>'po'],
            ['key'=>'po_next_number','value'=>'1','label'=>'Nomor Urut PO Berikutnya','group'=>'po'],
            ['key'=>'default_tax_rate','value'=>'11','label'=>'Tarif PPN Default (%)','group'=>'tax'],
            ['key'=>'pph23_rate','value'=>'2','label'=>'Tarif PPh 23 (%)','group'=>'tax'],
            ['key'=>'npwp','value'=>'','label'=>'NPWP Perusahaan','group'=>'tax'],
            ['key'=>'pkp_status','value'=>'pkp','label'=>'Status PKP','group'=>'tax'],
            ['key'=>'default_payment_term','value'=>'30','label'=>'Termin Pembayaran Default (hari)','group'=>'payment'],
            ['key'=>'default_dp_percent','value'=>'50','label'=>'DP Default (%)','group'=>'payment'],
            ['key'=>'default_currency','value'=>'IDR','label'=>'Mata Uang Utama','group'=>'general'],
            ['key'=>'usd_rate','value'=>'15850','label'=>'Kurs USD','group'=>'general'],
            ['key'=>'company_name','value'=>'153 Kreatif Techno','label'=>'Nama Perusahaan','group'=>'general'],
            ['key'=>'company_address','value'=>'','label'=>'Alamat Perusahaan','group'=>'general'],
            ['key'=>'commission_sales_rate','value'=>'5','label'=>'Rate Komisi Sales (%)','group'=>'commission'],
            ['key'=>'commission_ops_rate','value'=>'3','label'=>'Rate Komisi Operations (%)','group'=>'commission'],
        ]);
    }

    public function down(): void {
        Schema::dropIfExists('fin_settings');
    }
};
