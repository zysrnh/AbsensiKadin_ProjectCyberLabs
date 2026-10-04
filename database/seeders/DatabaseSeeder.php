<?php

namespace Database\Seeders;

use App\Models\Participant;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

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

        // 8 Akun Wonderful
        $this->call(UserSeeder::class);

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

        // Salin file flyer seeder.avif ke public uploads jika ada
        $flyerPath = 'uploads/flyers/seeder.avif';
        $sourceAvif = base_path('seeder.avif');
        $destAvif = public_path($flyerPath);

        if (File::exists($sourceAvif)) {
            File::ensureDirectoryExists(dirname($destAvif));
            File::copy($sourceAvif, $destAvif);
        }

        // Pengaturan Acara The Executive Roundtable — AI Ambition
        $eventSettings = [
            'event_title' => 'The Executive Roundtable — From AI Ambition to Enterprise Impact',
            'event_organizer' => 'Daphne Kusuma, Dina Ernawati Saksono',
            'event_date' => 'Selasa, 27 Oktober 2026',
            'event_time' => '15.30 – 19.00 WIB',
            'event_venue_name' => 'SCBD Area',
            'event_venue_address' => 'Kecamatan Kebayoran Baru, Daerah Khusus Ibukota Jakarta',
            'event_maps_url' => 'https://maps.app.goo.gl/Yqf5dogJJoUBUDhL7',
            'event_maps_iframe' => '<iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3966.263687846793!2d106.8098534!3d-6.228925399999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNsKwMTMnNDQuMSJTIDEwNsKwNDgnMzUuNSJF!5e0!3m2!1sid!2sid!4v1790947178610!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>',
            'event_dresscode' => 'By invitation only. Kindly confirm your attendance with the GWI team',
            'event_description' => "AI ambition is easy to announce. Enterprise impact takes leadership.\n\nWhere can AI create meaningful value in your business—and what must change across your people, systems and governance to make it happen?\n\nThe Executive Roundtable — From AI Ambition to Enterprise Impact, convened by Wonderful.ai, brings together approximately 20 C-level leaders across sectors for an invitation-only exchange on the decisions that turn AI potential into operational capability and measurable business outcomes.\n\nThrough a live presentation and demonstration, followed by a strategic roundtable and executive Q&A, explore where AI agents can contribute to enterprise operations, what stands between a promising pilot and wider implementation, and how leaders can pursue efficiency while maintaining trust and accountability.\n\nBring your questions, test your assumptions and exchange perspectives with fellow decision-makers. Continue the conversation over dinner, with fresh insight into what your organisation’s next AI move should be.",
            'event_flyer' => File::exists($destAvif) ? $flyerPath : '',
            'event_flyer_fit' => 'contain',
            'registration_deadline_enabled' => '1',
            'registration_deadline' => '2026-10-27T15:30',
            'registration_deadline_text' => '27 Oktober 2026, 15:30 WIB',
        ];

        foreach ($eventSettings as $key => $val) {
            Setting::set($key, $val);
        }
    }
}
