<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Clear existing items first to prevent duplicates on redeploy
        DB::table('menu_items')->truncate();

        DB::table('menu_items')->insert([
            // ── Coffee ────────────────────────────────────────────
            [
                'name'        => 'Espresso',
                'description' => 'A bold, concentrated shot of pure coffee.',
                'price'       => 89.00,
                'category'    => 'coffee',
                'emoji'       => '☕',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Americano',
                'description' => 'Espresso diluted with hot water for a smooth, rich taste.',
                'price'       => 99.00,
                'category'    => 'coffee',
                'emoji'       => '☕',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Cappuccino',
                'description' => 'Equal parts espresso, steamed milk, and velvety foam.',
                'price'       => 129.00,
                'category'    => 'coffee',
                'emoji'       => '☕',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Café Latte',
                'description' => 'Espresso with lots of steamed milk and a light layer of foam.',
                'price'       => 129.00,
                'category'    => 'coffee',
                'emoji'       => '☕',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Caramel Macchiato',
                'description' => 'Vanilla-flavored espresso marked with caramel drizzle.',
                'price'       => 149.00,
                'category'    => 'coffee',
                'emoji'       => '☕',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Cold Brew',
                'description' => 'Slow-steeped for 12 hours, smooth and low acidity.',
                'price'       => 149.00,
                'category'    => 'coffee',
                'emoji'       => '🧊',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],

            // ── Non-Coffee ─────────────────────────────────────────
            [
                'name'        => 'Matcha Latte',
                'description' => 'Ceremonial grade matcha whisked with steamed milk.',
                'price'       => 139.00,
                'category'    => 'noncoffee',
                'emoji'       => '🍵',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Chocolate Frappe',
                'description' => 'Rich blended chocolate with whipped cream on top.',
                'price'       => 149.00,
                'category'    => 'noncoffee',
                'emoji'       => '🍫',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Strawberry Milk',
                'description' => 'Fresh strawberry syrup blended with cold creamy milk.',
                'price'       => 119.00,
                'category'    => 'noncoffee',
                'emoji'       => '🍓',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Taro Milk Tea',
                'description' => 'Creamy taro root blended into a smooth milk tea.',
                'price'       => 139.00,
                'category'    => 'noncoffee',
                'emoji'       => '🧋',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],

            // ── Pastries ───────────────────────────────────────────
            [
                'name'        => 'Butter Croissant',
                'description' => 'Flaky, golden layers of buttery pastry, baked fresh daily.',
                'price'       => 79.00,
                'category'    => 'pastry',
                'emoji'       => '🥐',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Blueberry Muffin',
                'description' => 'Moist muffin bursting with fresh blueberries.',
                'price'       => 89.00,
                'category'    => 'pastry',
                'emoji'       => '🫐',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Cinnamon Roll',
                'description' => 'Soft, pillowy roll swirled with cinnamon and glazed icing.',
                'price'       => 99.00,
                'category'    => 'pastry',
                'emoji'       => '🌀',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Chocolate Éclair',
                'description' => 'Choux pastry filled with cream and topped with chocolate.',
                'price'       => 109.00,
                'category'    => 'pastry',
                'emoji'       => '🍫',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],

            // ── Food ──────────────────────────────────────────────
            [
                'name'        => 'Nest Club Sandwich',
                'description' => 'Triple-decker with chicken, bacon, egg, and fresh veggies.',
                'price'       => 195.00,
                'category'    => 'food',
                'emoji'       => '🥪',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Eggs Benedict',
                'description' => 'Poached eggs on an English muffin with hollandaise sauce.',
                'price'       => 220.00,
                'category'    => 'food',
                'emoji'       => '🍳',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Avocado Toast',
                'description' => 'Smashed avocado on sourdough with chili flakes and sea salt.',
                'price'       => 175.00,
                'category'    => 'food',
                'emoji'       => '🥑',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Pasta Aglio e Olio',
                'description' => 'Spaghetti tossed in garlic-infused olive oil with parsley.',
                'price'       => 210.00,
                'category'    => 'food',
                'emoji'       => '🍝',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ]);
    }
}