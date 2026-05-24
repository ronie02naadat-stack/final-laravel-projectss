<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserAccount;
use App\Models\Student;
use App\Models\Degree;
use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $firstNames = ['John', 'Maria', 'Juan', 'Anna', 'Robert', 'Lisa', 'Carlos', 'Sarah', 'Michael', 'Patricia', 'James', 'Jennifer', 'David', 'Mary', 'Daniel'];
        $middleNames = ['Cruz', 'Santos', 'Manuel', 'Marie', 'James', 'Ann', 'Antonio', 'Elizabeth', 'David', 'Rose', 'Christopher', 'Anne', 'Garcia', 'Marie', 'Rodriguez'];
        $lastNames = ['Santos', 'Dela Cruz', 'Reyes', 'Garcia', 'Torres', 'Johnson', 'Smith', 'Mendoza', 'Lopez', 'Martinez'];
        $addresses = ['123 Maple St', '456 Oak Ave', '789 Pine Rd', '321 Elm St', '654 Cedar Ave', '987 Birch Rd', '147 Walnut St', '258 Ash Ave'];
        $contactNumbers = ['09171234567', '09172345678', '09173456789', '09174567890', '09175678901', '09176789012', '09177890123', '09178901234', '09179012345', '09180123456'];

        $degrees = Degree::all();
        $studentCount = 0;
        
        // Create 5 students per degree
        foreach ($degrees as $degree) {
            $degreeCoursesIds = $degree->courses()->pluck('id')->toArray();
            
            for ($i = 0; $i < 5; $i++) {
                $firstName = $firstNames[array_rand($firstNames)];
                $middleName = $middleNames[array_rand($middleNames)];
                $lastName = $lastNames[array_rand($lastNames)];
                $email = strtolower($firstName . '.' . $lastName . $studentCount . '@student.rfn.com');
                $address = $addresses[array_rand($addresses)];
                $contact = $contactNumbers[array_rand($contactNumbers)];

                // Create User
                $user = User::create([
                    'name' => "$firstName $lastName",
                    'email' => $email,
                    'user_type' => 'student',
                    'password' => Hash::make('Student@12345'),
                    'password_changed' => true,
                ]);

                // Create UserAccount with unique username
                $userAccount = UserAccount::create([
                    'username' => strtolower($firstName . '.' . $lastName . $studentCount),
                    'email' => $email,
                    'password' => Hash::make('Student@12345'),
                    'role' => 'student',
                    'is_active' => true,
                ]);

                // Link User to UserAccount
                $user->update(['user_account_id' => $userAccount->id]);

                // Create Student
                $student = Student::create([
                    'first_name' => $firstName,
                    'middle_name' => $middleName,
                    'last_name' => $lastName,
                    'address' => $address,
                    'contact_number' => $contact,
                    'degree_id' => $degree->id,
                    'user_account_id' => $userAccount->id,
                ]);

                // Auto-enroll in degree courses
                if (!empty($degreeCoursesIds)) {
                    $student->courses()->attach($degreeCoursesIds);
                }

                $studentCount++;
            }
        }

        $this->command->info('✅ ' . $studentCount . ' students created successfully!');
        $this->command->info('📚 5 students per degree, auto-enrolled in all degree courses');
    }
}
