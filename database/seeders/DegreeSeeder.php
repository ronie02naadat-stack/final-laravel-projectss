<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Degree;

class DegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $degrees = [
            [
                'degree_title' => 'Bachelor of Science in Computer Science',
                'degree_code' => 'BSCS',
                'description' => 'A comprehensive program covering software development, algorithms, databases, and computer architecture.',
            ],
            [
                'degree_title' => 'Bachelor of Science in Information Technology',
                'degree_code' => 'BSIT',
                'description' => 'Focus on IT systems, networks, cybersecurity, and technology management.',
            ],
            [
                'degree_title' => 'Bachelor of Science in Business Administration',
                'degree_code' => 'BSBA',
                'description' => 'Core business education including management, accounting, marketing, and finance.',
            ],
            [
                'degree_title' => 'Bachelor of Science in Engineering',
                'degree_code' => 'BSE',
                'description' => 'Engineering fundamentals with specialization options in civil, mechanical, or electrical engineering.',
            ],
            [
                'degree_title' => 'Bachelor of Science in Nursing',
                'degree_code' => 'BSN',
                'description' => 'Professional nursing education and clinical practice training.',
            ],
            [
                'degree_title' => 'Bachelor of Arts in Psychology',
                'degree_code' => 'BAP',
                'description' => 'Study of human behavior, mental health, and psychological research methods.',
            ],
            [
                'degree_title' => 'Bachelor of Science in Biology',
                'degree_code' => 'BSB',
                'description' => 'Life sciences education covering cells, genetics, ecology, and evolution.',
            ],
            [
                'degree_title' => 'Bachelor of Science in Chemistry',
                'degree_code' => 'BSCH',
                'description' => 'Study of matter, chemical reactions, and analytical chemistry.',
            ],
            [
                'degree_title' => 'Bachelor of Science in Mathematics',
                'degree_code' => 'BSMA',
                'description' => 'Advanced mathematics including calculus, algebra, statistics, and applied mathematics.',
            ],
            [
                'degree_title' => 'Bachelor of Arts in Education',
                'degree_code' => 'BAE',
                'description' => 'Teacher education program with subject specialization and teaching methodology.',
            ],
        ];

        foreach ($degrees as $degree) {
            Degree::create($degree);
        }

        echo "✅ " . count($degrees) . " degree programs created successfully!\n";
        foreach ($degrees as $degree) {
            echo "   📚 " . $degree['degree_title'] . " (" . $degree['degree_code'] . ")\n";
        }
    }
}

