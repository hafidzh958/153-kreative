<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$portfolios = App\Models\Portfolio::all();
foreach($portfolios as $p) {
    if (!$p->category) {
        echo "ORPHAN DETECTED: ID {$p->id} - {$p->title} - Cat ID {$p->category_id}\n";
        if ($p->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($p->image);
            echo "Deleted image {$p->image}\n";
        }
        $p->delete();
        echo "Deleted orphan portfolio {$p->id}\n";
    } else {
        echo "VALID: ID {$p->id} - {$p->title} - Cat ID {$p->category_id}\n";
    }
}
echo "Script finished.\n";
