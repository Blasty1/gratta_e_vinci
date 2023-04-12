<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i < 14; $i++)
        {
            Employee::create(
                [
                    'user_id' => $i,
                    'tobaccoShop_id' => 1
                ]
            );
        }
    }
}
