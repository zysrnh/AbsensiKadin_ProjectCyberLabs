<?php

namespace Database\Seeders;

use App\Models\Participant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::firstOrCreate(
            ['email' => 'admin@kadin.id'],
            [
                'name' => 'Administrator Kadin',
                'password' => bcrypt('password'),
            ]
        );

        // Contoh Peserta 1
        Participant::firstOrCreate(
            ['email' => 'hendra.wijaya@example.com'],
            [
                'name' => 'Hendra Wijaya, S.E.',
                'phone_number' => '081234567890',
                'institution' => 'Kadin Jawa Barat / Komite Perdagangan',
                'qr_token' => 'KD26-HNDR8890',
                'status' => 'registered',
            ]
        );

        // Contoh Peserta 2
        Participant::firstOrCreate(
            ['email' => 'siti.nurhaliza@example.com'],
            [
                'name' => 'Ir. Hj. Siti Nurhaliza',
                'phone_number' => '082198765432',
                'institution' => 'PT Cyberlabs Teknologi Indonesia',
                'qr_token' => 'KD26-CYBER001',
                'status' => 'attended',
                'attended_at' => now()->subMinutes(15),
            ]
        );
    }
}

