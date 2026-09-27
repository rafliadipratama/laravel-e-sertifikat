<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Sample Admin User
        User::firstOrCreate(
            ['email' => 'admin@esertifikat.local'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password123'),
            ]
        );

        // Sample Event
        $event = Event::firstOrCreate(
            ['title' => 'Workshop Nasional: Rekayasa Prompt & Sistem AI 2026'],
            [
                'description' => 'Pelatihan intensif pemanfaatan Large Language Models dan integrasi otomasi kecerdasan buatan dalam alur kerja rekayasa perangkat lunak.',
                'organizer' => 'Pusat Riset Teknologi Informasi & Komunikasi',
                'event_date' => now()->toDateString(),
                'location' => 'Online via Zoom Video Conference',
                'signer_name' => 'Dr. Budi Santoso, M.Kom',
                'signer_position' => 'Direktur Eksekutif Program',
                'certificate_prefix' => 'SERT/AI-DEV/2026',
            ]
        );

        // Sample Participants & Certificates
        $participants = [
            [
                'name' => 'Muhammad Rafli Adi Pratama',
                'email' => 'rafliadipratma@gmail.com',
                'role' => 'Peserta Terbaik',
                'description' => 'Berhasil menyelesaikan proyek integrasi model AI dan automasi dengan predikat Sangat Memuaskan.',
            ],
            [
                'name' => 'Dr. Hendra Gunawan, S.Kom., M.T.',
                'email' => 'hendra.gunawan@example.com',
                'role' => 'Narasumber Utama',
                'description' => 'Pemateri sesi arsitektur agen AI dan pipeline prompt engineering tingkat lanjut.',
            ],
            [
                'name' => 'Siti Nurhaliza, S.T.',
                'email' => 'siti.nurhaliza@example.com',
                'role' => 'Moderator',
                'description' => 'Memandu jalannya diskusi interaktif dan workshop teknis dari awal hingga selesai.',
            ],
        ];

        foreach ($participants as $index => $item) {
            $number = sprintf('%s/%04d', $event->certificate_prefix, $index + 1);

            Certificate::firstOrCreate(
                ['certificate_number' => $number],
                [
                    'event_id' => $event->id,
                    'recipient_name' => $item['name'],
                    'recipient_email' => $item['email'],
                    'role' => $item['role'],
                    'description' => $item['description'],
                    'issue_date' => now()->toDateString(),
                    'verification_token' => Str::random(40),
                ]
            );
        }
    }
}
