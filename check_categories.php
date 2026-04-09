<?php

use App\Models\Product;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$categories = Product::select('category')->distinct()->pluck('category');
echo "Categories in DB:\n";
foreach ($categories as $cat) {
    echo "- '$cat'\n";
}
