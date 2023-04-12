<?php

namespace Database\Seeders;

use App\Models\TobaccoShop;
use Illuminate\Database\Seeder;

class TobaccoShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TobaccoShop::create([
            'name' => 'Bar Bivio',
            'street_address' => 'Avellino Ariano Irpino 83031',
            'user_id' => 1,
            'token' => \Str::random(10),
        ]);
    }
}
