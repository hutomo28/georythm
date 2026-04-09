<?php

use App\Models\Product;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$count = Product::where('category', 'Arcteryx')->update(['category' => "Arc'teryx"]);
echo "Updated $count products from 'Arcteryx' to 'Arc\'teryx'.\n";
