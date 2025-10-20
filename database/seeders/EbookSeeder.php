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
                'title' => 'Soal Assessment Siswa Kelas X.pdf',
                'author' => 'admin',
                'description' => 'lorem',
                'filepath' => 'pdf1.pdf',
            ],
            [
                'title' => 'Soal Assessment Siswa Kelas XI.pdf',
                'author' => 'admin',
                'description' => 'lorem',
                'filepath' => 'pdf2.pdf',
            ],
            [
                'title' => 'Soal Assessment Siswa Kelas XII.pdf',
                'author' => 'admin',
                'description' => 'lorem',
                'filepath' => 'pdf3.pdf',
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
