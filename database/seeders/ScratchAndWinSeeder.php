<?php

namespace Database\Seeders;

use App\Models\ScratchAndWin;
use Illuminate\Database\Seeder;

class ScratchAndWinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itemsToStore =  \Config::get('scratchAndWinApp');
        foreach ( $itemsToStore as $singleItem )
        {
            ScratchAndWin::create($singleItem);
        }
        
    }
}
