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
        for ( $i = 0; $i <10 ; $i++)
        {
            ScratchAndWin::create([
                'name' => \Str::random(10),
                'prize' => rand($i,50),
                'token' => \Str::random(4),
            ]);
        }
        
    }
}
