<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        //Userek létrehozása

        $users_count = random_int(1,5);
        $users = collect();

        for($i = 1; $i <= $users_count; $i++){
            $users->add(
                \App\Models\User::factory()
                ->create([
                    'email' => 'user'.$i.'@szerveroldali.hu'
                ])
            );
        }

        //Admin létrehozása

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@szerveroldali.hu',
            'password' => Hash::make('password'),
        ]);

    }
}
