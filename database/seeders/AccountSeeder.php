<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = collect([
            [
                'name' => 'Fulan',
                'email' => 'fulan@laravel-fmg.com',
                'password' => bcrypt('password')
            ],
            [
                'name' => 'Fulanah',
                'email' => 'fulanah@laravel-fmg.com',
                'password' => bcrypt('password')
            ]
        ]);

        $user->each(function ($item) {
            User::create($item);
        });
    }
}
