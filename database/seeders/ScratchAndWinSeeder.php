<?php

namespace Database\Seeders;

use App\Models\ScratchAndWin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

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
            if(!is_array($singleItem) ) continue;
            ScratchAndWin::create($singleItem);
        }
        
    }
}
