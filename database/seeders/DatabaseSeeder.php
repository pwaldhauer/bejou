<?php

namespace Database\Seeders;

use App\Models\Journal;
use App\Models\User;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        \App\Models\User::factory(1)->create([
            'email' => 'hi@pwa.io',
            'password' => Hash::make('testtest')
        ]);

        // Todo: Das geht sicher eleganter
        $years = [2019, 2021, 2022];
        foreach($years as $year) {
            for($i = 0; $i < 300; $i++) {
                Journal::factory(1)->create([
                    'date' => sprintf('%s-%02d-%02d 12:00:00', $year, rand(1, 12), rand(1,29))
                ]);
            }

        }


    }
}
