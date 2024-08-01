<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CleanShareLinksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all cart orders
        $cartOrders = DB::table('cart_orders')->get();

        foreach ($cartOrders as $cartOrder) {
            // Decode the JSON data stored in the cart column
            $cartData = json_decode($cartOrder->cart, true);

            // Check if the type in the JSON data is 'project'
            if (isset($cartData['type']) && $cartData['type'] === 'project' && ($cartOrder->status == 1 || $cartOrder->status == 0)) {
                // Ensure that 'item' key and its 'id' and 'housing' fields exist
                if (isset($cartData['item']['id']) && isset($cartData['item']['housing'])) {
                    DB::table('share_links')
                        ->where('item_type', 1)
                        ->where('item_id', $cartData['item']['id'])
                        ->where('room_order', $cartData['item']['housing'])
                        ->delete();
                }
            }


            // Check if the type in the JSON data is 'project'
            if (isset($cartData['type']) && $cartData['type'] === 'housing' && ($cartOrder->status == 1 || $cartOrder->status == 0)) {
                // Ensure that 'item' key and its 'id' and 'housing' fields exist
                if (isset($cartData['item']['id'])) {
                    DB::table('share_links')
                        ->where('item_type', 2)
                        ->where('item_id', $cartData['item']['id'])
                        ->delete();
                }
            }
        }
    }
}
