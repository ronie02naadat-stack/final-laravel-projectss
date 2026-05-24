<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachersData = [
            [
                'name' => 'Dr. Maria Santos',
                'email' => 'maria.santos@rfn.com',
                'first_name' => 'Maria',
                'middle_name' => 'Cruz',
                'last_name' => 'Santos',
                'specialization' => 'Data Science & Machine Learning',
                'experience_years' => 12,
                'office_location' => 'Building A, Room 301',
                'contact_number' => '09171234567',
            ],
            [
                'name' => 'Dr. Juan Dela Cruz',
                'email' => 'juan.delacruz@rfn.com',
                'first_name' => 'Juan',
                'middle_name' => 'Manuel',
                'last_name' => 'Dela Cruz',
                'specialization' => 'Web Development & Cloud Architecture',
                'experience_years' => 10,
                'office_location' => 'Building B, Room 205',
                'contact_number' => '09172345678',
            ],
            [
                'name' => 'Prof. Anna Reyes',
                'email' => 'anna.reyes@rfn.com',
                'first_name' => 'Anna',
                'middle_name' => 'Marie',
                'last_name' => 'Reyes',
                'specialization' => 'Database Design & SQL',
                'experience_years' => 8,
                'office_location' => 'Building A, Room 205',
                'contact_number' => '09173456789',
            ],
            [
                'name' => 'Prof. Robert Torres',
                'email' => 'robert.torres@rfn.com',
                'first_name' => 'Robert',
                'middle_name' => 'James',
                'last_name' => 'Torres',
                'specialization' => 'Software Engineering & Design Patterns',
                'experience_years' => 15,
                'office_location' => 'Building C, Room 102',
                'contact_number' => '09174567890',
            ],
            [
                'name' => 'Prof. Lisa Garcia',
                'email' => 'lisa.garcia@rfn.com',
                'first_name' => 'Lisa',
                'middle_name' => 'Ann',
                'last_name' => 'Garcia',
                'specialization' => 'Business Management & Accounting',
                'experience_years' => 9,
                'office_location' => 'Building D, Room 301',
                'contact_number' => '09175678901',
            ],
            [
                'name' => 'Dr. Michael Johnson',
                'email' => 'michael.johnson@rfn.com',
                'first_name' => 'Michael',
                'middle_name' => 'David',
                'last_name' => 'Johnson',
                'specialization' => 'Healthcare & Nursing Management',
                'experience_years' => 11,
                'office_location' => 'Building E, Room 401',
                'contact_number' => '09176789012',
            ],
            [
                'name' => 'Prof. Sarah Smith',
                'email' => 'sarah.smith@rfn.com',
                'first_name' => 'Sarah',
                'middle_name' => 'Elizabeth',
                'last_name' => 'Smith',
                'specialization' => 'Physics & Chemistry',
                'experience_years' => 7,
                'office_location' => 'Building A, Room 102',
                'contact_number' => '09177890123',
            ],
            [
                'name' => 'Prof. Carlos Mendoza',
                'email' => 'carlos.mendoza@rfn.com',
                'first_name' => 'Carlos',
                'middle_name' => 'Antonio',
                'last_name' => 'Mendoza',
                'specialization' => 'Education & Psychology',
                'experience_years' => 13,
                'office_location' => 'Building B, Room 401',
                'contact_number' => '09178901234',
            ],
        ];

        foreach ($teachersData as $data) {
            $name = $data['name'];
            $email = $data['email'];
            unset($data['name'], $data['email']);

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'user_type' => 'teacher',
                'password' => Hash::make('Teacher@12345'),
                'password_changed' => true,
            ]);

            Teacher::create(array_merge($data, ['user_id' => $user->id]));
        }

        $this->command->info('✅ 8 teachers created successfully!');
    }
}
