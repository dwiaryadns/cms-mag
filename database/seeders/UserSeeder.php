<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Marketing',
            'email' => 'marketing@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'marketing',
        ]);
        User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'MAGINSURANCE',
            'email' => 'maginsurance-api-test@gmail.com',
            'password' => bcrypt('M@g1nsur@nceH3@lth!S3cur3&Pr0t3ct#'),
            'role' => 'api-user',
        ]);
    }
}
