<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = [
            [
                'name' => 'Wonderful 1',
                'email' => 'wonderful1@wonderful.id',
                'password' => 'Won#2026!Alpha',
            ],
            [
                'name' => 'Wonderful 2',
                'email' => 'wonderful2@wonderful.id',
                'password' => 'Won#2026!Bravo',
            ],
            [
                'name' => 'Wonderful 3',
                'email' => 'wonderful3@wonderful.id',
                'password' => 'Won#2026!Charlie',
            ],
            [
                'name' => 'Wonderful 4',
                'email' => 'wonderful4@wonderful.id',
                'password' => 'Won#2026!Delta',
            ],
            [
                'name' => 'Wonderful 5',
                'email' => 'wonderful5@wonderful.id',
                'password' => 'Won#2026!Echo',
            ],
            [
                'name' => 'Wonderful 6',
                'email' => 'wonderful6@wonderful.id',
                'password' => 'Won#2026!Foxtrot',
            ],
            [
                'name' => 'Wonderful 7',
                'email' => 'wonderful7@wonderful.id',
                'password' => 'Won#2026!Golf',
            ],
            [
                'name' => 'Wonderful 8',
                'email' => 'wonderful8@wonderful.id',
                'password' => 'Won#2026!Hotel',
            ],
        ];

        foreach ($accounts as $acc) {
            User::updateOrCreate(
                ['email' => $acc['email']],
                [
                    'name' => $acc['name'],
                    'password' => Hash::make($acc['password']),
                ]
            );
        }
    }
}
