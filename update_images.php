<?php
use App\Models\Product;
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Product::where('name', 'like', '%kopi%')->update(['image' => 'products/coffee_aesthetic.png']);
Product::where('name', 'like', '%snack%')->orWhere('name', 'like', '%makanan%')->update(['image' => 'products/snack_aesthetic.png']);
echo "Updated images successfully!\n";
