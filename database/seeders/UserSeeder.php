<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'username' => "admin",
                'password' => bcrypt('qwerty123'),
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],
            [
                'username' => "user1",
                'password' => bcrypt('qwerty123'),
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],
            [
                'username' => "user2",
                'password' => bcrypt('qwerty123'),
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],

        ];
        \DB::table('users')->insert($user);
    }
}
