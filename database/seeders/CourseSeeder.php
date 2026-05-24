<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Degree;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = Teacher::all();
        if ($teachers->isEmpty()) {
            $this->command->error('❌ No teachers found. Run TeacherSeeder first.');
            return;
        }

        $coursesData = [
            // Computer Science courses
            [
                'degree_code' => 'BSCS',
                'courses' => [
                    ['code' => 'CS101', 'course_name' => 'Introduction to Programming', 'description' => 'Fundamentals of programming using Python', 'units' => 3],
                    ['code' => 'CS102', 'course_name' => 'Data Structures', 'description' => 'Arrays, linked lists, stacks, queues, and trees', 'units' => 4],
                    ['code' => 'CS201', 'course_name' => 'Database Management Systems', 'description' => 'SQL, indexing, and query optimization', 'units' => 4],
                    ['code' => 'CS202', 'course_name' => 'Web Development', 'description' => 'HTML, CSS, JavaScript, and Laravel frameworks', 'units' => 4],
                ]
            ],
            // Information Technology courses
            [
                'degree_code' => 'BSIT',
                'courses' => [
                    ['code' => 'IT101', 'course_name' => 'IT Fundamentals', 'description' => 'Computer hardware, software, and networks', 'units' => 3],
                    ['code' => 'IT102', 'course_name' => 'Network Administration', 'description' => 'Network setup, security, and management', 'units' => 4],
                    ['code' => 'IT201', 'course_name' => 'Cloud Computing', 'description' => 'AWS, Azure, and cloud infrastructure', 'units' => 4],
                    ['code' => 'IT202', 'course_name' => 'Cybersecurity Basics', 'description' => 'Security threats, encryption, and defense', 'units' => 3],
                ]
            ],
            // Business Administration courses
            [
                'degree_code' => 'BSBA',
                'courses' => [
                    ['code' => 'BA101', 'course_name' => 'Business Fundamentals', 'description' => 'Introduction to business concepts and principles', 'units' => 3],
                    ['code' => 'BA102', 'course_name' => 'Accounting Principles', 'description' => 'Financial statements and accounting methods', 'units' => 4],
                    ['code' => 'BA201', 'course_name' => 'Business Management', 'description' => 'Planning, organizing, and control', 'units' => 3],
                    ['code' => 'BA202', 'course_name' => 'Economics', 'description' => 'Micro and macroeconomic principles', 'units' => 3],
                ]
            ],
            // Engineering courses
            [
                'degree_code' => 'BSE',
                'courses' => [
                    ['code' => 'ENG101', 'course_name' => 'Engineering Mechanics', 'description' => 'Statics, dynamics, and kinematics', 'units' => 4],
                    ['code' => 'ENG102', 'course_name' => 'Thermodynamics', 'description' => 'Heat, energy, and thermodynamic laws', 'units' => 4],
                    ['code' => 'ENG201', 'course_name' => 'Circuit Analysis', 'description' => 'Electrical circuits and components', 'units' => 4],
                    ['code' => 'ENG202', 'course_name' => 'Materials Science', 'description' => 'Properties and applications of materials', 'units' => 3],
                ]
            ],
            // Nursing courses
            [
                'degree_code' => 'BSN',
                'courses' => [
                    ['code' => 'NUR101', 'course_name' => 'Fundamentals of Nursing', 'description' => 'Basic nursing concepts and patient care', 'units' => 4],
                    ['code' => 'NUR102', 'course_name' => 'Anatomy and Physiology', 'description' => 'Human body systems and functions', 'units' => 4],
                    ['code' => 'NUR201', 'course_name' => 'Clinical Nursing Practice', 'description' => 'Hands-on patient care skills', 'units' => 4],
                    ['code' => 'NUR202', 'course_name' => 'Pharmacology', 'description' => 'Drugs, medications, and their effects', 'units' => 3],
                ]
            ],
            // Psychology courses
            [
                'degree_code' => 'BAP',
                'courses' => [
                    ['code' => 'PSY101', 'course_name' => 'Introduction to Psychology', 'description' => 'Human behavior and mental processes', 'units' => 3],
                    ['code' => 'PSY102', 'course_name' => 'Developmental Psychology', 'description' => 'Human development across lifespan', 'units' => 3],
                    ['code' => 'PSY201', 'course_name' => 'Social Psychology', 'description' => 'Group behavior and social influence', 'units' => 3],
                    ['code' => 'PSY202', 'course_name' => 'Abnormal Psychology', 'description' => 'Mental disorders and treatments', 'units' => 3],
                ]
            ],
            // Biology courses
            [
                'degree_code' => 'BSB',
                'courses' => [
                    ['code' => 'BIO101', 'course_name' => 'General Biology', 'description' => 'Cell structure, genetics, and evolution', 'units' => 4],
                    ['code' => 'BIO102', 'course_name' => 'Biochemistry', 'description' => 'Chemical reactions in living organisms', 'units' => 4],
                    ['code' => 'BIO201', 'course_name' => 'Ecology', 'description' => 'Ecosystems, populations, and conservation', 'units' => 3],
                    ['code' => 'BIO202', 'course_name' => 'Microbiology', 'description' => 'Bacteria, viruses, and microorganisms', 'units' => 4],
                ]
            ],
            // Chemistry courses
            [
                'degree_code' => 'BSCH',
                'courses' => [
                    ['code' => 'CHM101', 'course_name' => 'General Chemistry', 'description' => 'Elements, compounds, and reactions', 'units' => 4],
                    ['code' => 'CHM102', 'course_name' => 'Organic Chemistry', 'description' => 'Carbon-based compounds and reactions', 'units' => 4],
                    ['code' => 'CHM201', 'course_name' => 'Analytical Chemistry', 'description' => 'Qualitative and quantitative analysis', 'units' => 4],
                    ['code' => 'CHM202', 'course_name' => 'Physical Chemistry', 'description' => 'Thermodynamics and quantum chemistry', 'units' => 4],
                ]
            ],
            // Mathematics courses
            [
                'degree_code' => 'BSMA',
                'courses' => [
                    ['code' => 'MAT101', 'course_name' => 'Calculus I', 'description' => 'Limits, derivatives, and integrals', 'units' => 4],
                    ['code' => 'MAT102', 'course_name' => 'Calculus II', 'description' => 'Advanced integration and series', 'units' => 4],
                    ['code' => 'MAT201', 'course_name' => 'Linear Algebra', 'description' => 'Matrices, vectors, and linear systems', 'units' => 3],
                    ['code' => 'MAT202', 'course_name' => 'Differential Equations', 'description' => 'Solutions and applications of DEs', 'units' => 3],
                ]
            ],
            // Education courses
            [
                'degree_code' => 'BAE',
                'courses' => [
                    ['code' => 'EDU101', 'course_name' => 'Educational Psychology', 'description' => 'Learning theories and student development', 'units' => 3],
                    ['code' => 'EDU102', 'course_name' => 'Curriculum Design', 'description' => 'Planning and organizing curriculum', 'units' => 3],
                    ['code' => 'EDU201', 'course_name' => 'Teaching Methods', 'description' => 'Strategies and techniques for instruction', 'units' => 3],
                    ['code' => 'EDU202', 'course_name' => 'Assessment & Evaluation', 'description' => 'Testing and grading methods', 'units' => 3],
                ]
            ],
        ];

        foreach ($coursesData as $degreeGroup) {
            $degree = Degree::where('degree_code', $degreeGroup['degree_code'])->first();
            if (!$degree) continue;

            foreach ($degreeGroup['courses'] as $courseData) {
                $teacher = $teachers->random();
                Course::create([
                    'course_name' => $courseData['course_name'],
                    'code' => $courseData['code'],
                    'description' => $courseData['description'],
                    'teacher_id' => $teacher->user_id,
                    'degree_id' => $degree->id,
                ]);
            }
        }

        $this->command->info('✅ 40 courses created successfully across 10 degrees!');
    }
}
