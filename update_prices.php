<?php
use App\Models\Product;
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$kopi = Product::where('name', 'like', '%kopi%')->first();
if ($kopi) {
    $kopi->update([
        'price_pack' => $kopi->price * 10,
        'units_per_pack' => 12
    ]);
    echo "Updated Kopi with pack price.\n";
}

$snack = Product::where('name', 'like', '%snack%')->first();
if ($snack) {
    $snack->update([
        'price_pack' => $snack->price * 5,
        'units_per_pack' => 6
    ]);
    echo "Updated Snack with pack price.\n";
}
