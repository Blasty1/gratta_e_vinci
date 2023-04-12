<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Bryan',
            'surname' => 'Blast',
            'email' => 'ichigoplayer18@gmail.com',
            'password' => \Hash::make('brunleon'),
            'street_address' => 'Avellino Ariano Irpino 83031',
        ]);
        User::create([
            'name' => 'Marco',
            'surname' => 'Blast',
            'email' => 'bruno.carchia@liceoparzanese.edu.it',
            'password' => \Hash::make('brunleon'),
            'street_address' => 'Avellino Ariano Irpino 83031',
        ]);

        for($i = 0 ; $i < 15; $i++)
        {
            User::create([
                'name' => \Str::random(10),
                'surname' => \Str::random(10),
                'email' => \Str::random(15) . '@gmail.com',
                'password' => \Hash::make('brunleon'),
                'street_address' => 'Avellino Ariano Irpino 83031',
            ]);
        }

    }
}
