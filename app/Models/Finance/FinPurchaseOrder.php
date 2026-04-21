<?php namespace App\Models\Finance;
use Illuminate\Database\Eloquent\Model;
class FinPurchaseOrder extends Model {
    protected $table = 'fin_purchase_orders';
    protected $fillable = ['po_number','vendor_name','vendor_contact','vendor_email','category','event_name','description','amount','paid_amount','date','delivery_date','status','notes'];
    protected $casts = ['date'=>'date','delivery_date'=>'date','amount'=>'decimal:2','paid_amount'=>'decimal:2'];
    public function getStatusLabelAttribute(): string { return match($this->status){'pending'=>'Menunggu','approved'=>'Disetujui','partial'=>'DP Dibayar','paid'=>'Lunas','rejected'=>'Ditolak',default=>ucfirst($this->status)}; }
    public function getCategoryLabelAttribute(): string { return match($this->category){'venue'=>'Venue','catering'=>'Catering','av'=>'AV/Multimedia','decoration'=>'Dekorasi','transport'=>'Transportasi','talent'=>'Talent','marketing'=>'Marketing',default=>'Lainnya'}; }
    public static function generateNumber(): string { $prefix=\DB::table('fin_settings')->where('key','po_prefix')->value('value')??'PO';$year=now()->format('Y');$month=now()->format('m');$next=(int)(\DB::table('fin_settings')->where('key','po_next_number')->value('value')??1);\DB::table('fin_settings')->where('key','po_next_number')->update(['value'=>$next+1]);return sprintf('%s-%s%s-%04d',$prefix,$year,$month,$next); }
}
