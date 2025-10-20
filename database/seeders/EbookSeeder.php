<?php

namespace Database\Seeders;

use App\Models\Ebook;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate([
            "email" => "admin@gmail.com",
        ],
        [
            'name' => 'admin',
            'password' => Hash::make('admin123'),
            'remember_token' => Str::random(10)
        ]);

        // generate data ebook
        $ebookData = [
            [
                'title' => 'The Laravel Co-pilot Guide',
                'author' => 'Senior Engineer',
                'description' => 'Panduan lengkap menjadi Senior Software Engineer Laravel.',
                'price' => 49.99,
                // PATH PENTING: Ganti dengan nama file PDF dummy Anda
                'filepath' => 'Soal Assesment Siswa Kelas X.pdf',
            ],
            [
                'title' => 'Deep Dive into Tailwind CSS',
                'author' => 'Tailwind Expert',
                'description' => 'Mempelajari Utility-First CSS secara mendalam.',
                'price' => 29.50,
                'filepath' => 'Soal Assesment Siswa Kelas XI.pdf',
            ],
            [
                'title' => 'Secure PDF Viewer with JS',
                'author' => 'Security Consultant',
                'description' => 'Teknik memblokir download dan copy pada konten web.',
                'price' => 99.00,
                'filepath' => 'Soal Assesment Siswa Kelas XII.pdf',
            ]
        ];

        foreach ($ebookData as $data) {
            Ebook::firstOrCreate(
                ['title' => $data['title']],
                array_merge($data, [
                    'user_id' => $user->id,
                ])
            );
        }
    }
}
