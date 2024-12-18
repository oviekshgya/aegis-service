<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = [
            [
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'user_id' => 2,
                'created_at' => now(),
            ],
            [
                'user_id' => 3,
                'created_at' => now(),
            ],
        ];

        DB::table('orders')->insert($orders);
    }
}
