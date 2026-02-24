<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // National Geographic
            [
                'name' => 'NG Quest Down Jacket',
                'description' => 'Premium goose down jacket for extreme cold protection.',
                'price' => 7499000,
                'image' => 'https://images.unsplash.com/photo-1544923246-77307dd654ca?q=80&w=1974&auto=format&fit=crop',
                'image2' => 'https://images.unsplash.com/photo-1539533018447-da3d13b49e61?q=80&w=1974&auto=format&fit=crop',
                'image3' => 'https://images.unsplash.com/photo-1620803135981-5905ef9e22ea?q=80&w=1974&auto=format&fit=crop',
                'category' => 'National Geographic',
                'size' => 'L',
                'stock' => 15,
            ],
            [
                'name' => 'NG Urban Explorer Shell',
                'description' => 'Versatile waterproof shell for city explorers.',
                'price' => 3299000,
                'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=1936&auto=format&fit=crop',
                'image2' => 'https://images.unsplash.com/photo-1511406361295-0a1ff814c0ce?q=80&w=1974&auto=format&fit=crop',
                'image3' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?q=80&w=1935&auto=format&fit=crop',
                'category' => 'National Geographic',
                'size' => 'M',
                'stock' => 20,
            ],
            // The North Face
            [
                'name' => 'TNF Nuptse 1996 Retro',
                'description' => 'Iconic puffy jacket with high-loft down insulation.',
                'price' => 5499000,
                'image' => 'https://images.unsplash.com/photo-1604644401890-0bd678c83788?q=80&w=2070&auto=format&fit=crop',
                'image2' => 'https://images.unsplash.com/photo-1516245834210-c4c142787335?q=80&w=2069&auto=format&fit=crop',
                'image3' => 'https://images.unsplash.com/photo-1608231387042-66d1773070a5?q=80&w=1974&auto=format&fit=crop',
                'category' => 'The North Face',
                'size' => 'XL',
                'stock' => 10,
            ],
            [
                'name' => 'TNF Mountain Light Jacket',
                'description' => 'Lightweight and durable mountain jacket with Futurelight technology.',
                'price' => 4599000,
                'image' => 'https://images.unsplash.com/photo-1620803135981-5905ef9e22ea?q=80&w=1974&auto=format&fit=crop',
                'image2' => 'https://images.unsplash.com/photo-1544923246-77307dd654ca?q=80&w=1974&auto=format&fit=crop',
                'image3' => 'https://images.unsplash.com/photo-1516245834210-c4c142787335?q=80&w=2069&auto=format&fit=crop',
                'category' => 'The North Face',
                'size' => 'L',
                'stock' => 12,
            ],
            // Arc'teryx
            [
                'name' => 'Alpha SV Jacket',
                'description' => 'The most durable Gore-Tex Pro shell for severe alpine conditions.',
                'price' => 9899000,
                'image' => 'https://images.unsplash.com/photo-1521223344201-d169129f7b7d?q=80&w=1934&auto=format&fit=crop',
                'image2' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?q=80&w=1935&auto=format&fit=crop',
                'image3' => 'https://images.unsplash.com/photo-1511406361295-0a1ff814c0ce?q=80&w=1974&auto=format&fit=crop',
                'category' => 'Arc\'teryx',
                'size' => 'M',
                'stock' => 5,
            ],
            [
                'name' => 'Atom LT Hoody',
                'description' => 'Versatile synthetic insulated midlayer with wind and moisture resistance.',
                'price' => 4299000,
                'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?q=80&w=1935&auto=format&fit=crop',
                'image2' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=1936&auto=format&fit=crop',
                'image3' => 'https://images.unsplash.com/photo-1608231387042-66d1773070a5?q=80&w=1974&auto=format&fit=crop',
                'category' => 'Arc\'teryx',
                'size' => 'L',
                'stock' => 18,
            ],
            // Columbia
            [
                'name' => 'Columbia Omni-Heat Infinity',
                'description' => 'Advanced thermal-reflective lining for maximum warmth.',
                'price' => 2899000,
                'image' => 'https://images.unsplash.com/photo-1588359348347-9bc6cbb669ff?q=80&w=1974&auto=format&fit=crop',
                'image2' => 'https://images.unsplash.com/photo-1644331422700-47963d8d6484?q=80&w=2070&auto=format&fit=crop',
                'image3' => 'https://images.unsplash.com/photo-1544923246-77307dd654ca?q=80&w=1974&auto=format&fit=crop',
                'category' => 'Columbia',
                'size' => 'XL',
                'stock' => 25,
            ],
            [
                'name' => 'Columbia Watertight II',
                'description' => 'Classic packable rain jacket for wet weather protection.',
                'price' => 1299000,
                'image' => 'https://images.unsplash.com/photo-1644331422700-47963d8d6484?q=80&w=2070&auto=format&fit=crop',
                'image2' => 'https://images.unsplash.com/photo-1588359348347-9bc6cbb669ff?q=80&w=1974&auto=format&fit=crop',
                'image3' => 'https://images.unsplash.com/photo-1516245834210-c4c142787335?q=80&w=2069&auto=format&fit=crop',
                'category' => 'Columbia',
                'size' => 'S',
                'stock' => 30,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
