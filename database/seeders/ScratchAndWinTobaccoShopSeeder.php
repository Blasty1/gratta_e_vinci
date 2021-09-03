<?php

namespace Database\Seeders;

use App\Models\ScratchAndWinTobaccoShop;
use Illuminate\Database\Seeder;

class ScratchAndWinTobaccoShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i < 20; $i++)
        {
        ScratchAndWinTobaccoShop::create(
            [
                'tobaccoShop_id' => 1,
                'scratchAndWin_id' => rand(1,10) ,
                'quantity' => rand(1,1000),
                'employee_id' => rand(2,13),

            ]
        );
    }
    }
}
