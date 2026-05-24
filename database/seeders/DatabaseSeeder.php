<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Degree;
use App\Models\Student;
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
        $this->call([
            AdminSeeder::class,
            DegreeSeeder::class,
            TeacherSeeder::class,
            CourseSeeder::class,
            StudentSeeder::class,
        ]);

        $this->command->info('✅ Database seeding completed successfully!');
    }
}
