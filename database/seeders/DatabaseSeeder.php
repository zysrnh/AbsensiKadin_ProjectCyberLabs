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
            ['qr_token' => 'KD26-HNDR8890'],
            [
                'name' => 'Hendra Wijaya, S.E.',
                'company' => 'Kadin Jawa Barat',
                'position' => 'Wakil Ketua Bidang Perdagangan',
                'phone' => '081234567890',
                'email' => 'hendra.wijaya@example.com',
                'status' => 'registered',
            ]
        );

        // Contoh Peserta 2
        Participant::firstOrCreate(
            ['qr_token' => 'KD26-CYBER001'],
            [
                'name' => 'Ir. Hj. Siti Nurhaliza',
                'company' => 'PT Cyberlabs Teknologi Indonesia',
                'position' => 'Chief Technology Officer',
                'phone' => '082198765432',
                'email' => 'siti.nurhaliza@example.com',
                'status' => 'attended',
                'attended_at' => now()->subMinutes(15),
            ]
        );
    }
}


