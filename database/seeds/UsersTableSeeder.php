<?php
use App\Course;
use App\CourseStudentCount;
use App\Enrollment;
use App\Institute;
use App\Student;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // // Courses
        // $course_1 = Course::create([
        //     'course_name' => 'JEE 2019-20',
        //     'course_description' => 'Entrance Exam For Getting Into IITs & NITs for the batch 2019-20'
        // ]);

        // $course_2 = Course::create([
        //     'course_name' => 'NEET 2019-20',
        //     'course_description' => 'Entrance Exam For Getting Into Medical Colleges for the batch 2019-20'
        // ]);

        // // Subjects
        // $subject_1 = \App\Subject::create([
        //     'subject_name' => 'Physics'
        // ]);

        // $subject_2 = \App\Subject::create([
        //     'subject_name' => 'Chemistry'
        // ]);

        // $subject_3 = \App\Subject::create([
        //     'subject_name' => 'Mathematics'
        // ]);

        // // Chapters
        // \App\Chapter::create([
        //     'chapter_name' => 'Phy1',
        //     'chapter_description' => 'Phy1',
        //     'subject_id' => $subject_1->subject_id
        // ]);

        // \App\Chapter::create([
        //     'chapter_name' => 'Phy2',
        //     'chapter_description' => 'Phy2',
        //     'subject_id' => $subject_1->subject_id
        // ]);

        // \App\Chapter::create([
        //     'chapter_name' => 'Chem1',
        //     'chapter_description' => 'Chem1',
        //     'subject_id' => $subject_2->subject_id
        // ]);

        // \App\Chapter::create([
        //     'chapter_name' => 'Chem2',
        //     'chapter_description' => 'Chem2',
        //     'subject_id' => $subject_2->subject_id
        // ]);

        // \App\Chapter::create([
        //     'chapter_name' => 'Math1',
        //     'chapter_description' => 'Math1',
        //     'subject_id' => $subject_3->subject_id
        // ]);

        // \App\Chapter::create([
        //     'chapter_name' => 'Math2',
        //     'chapter_description' => 'Math2',
        //     'subject_id' => $subject_3->subject_id
        // ]);

        // $course_1->subjects()->attach($subject_1);
        // $course_1->subjects()->attach($subject_2);
        // $course_1->subjects()->attach($subject_3);

        //Admin
        //1.
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123'),
            'contact_no' => '1234567890',
            'additional_columns' => 'additional columns',
            'address' => 'test address',
            'city' => 'test city',
            'email_verified_at' => Carbon::now()
        ]);
        $user->assignRole('Admin');

        // Institute
        // 1.
        $user = User::create([
            'name' => 'GES',
            'email' => 'ges@gmail.com',
            'password' => Hash::make('123'),
            'contact_no' => '1234567890',
            'additional_columns' => 'additional columns',
            'address' => 'test address',
            'city' => 'test city',
            'email_verified_at' => Carbon::now()
        ]);


        $user->assignRole('Institute');

        try {
            $institute_1 = Institute::create([
                'institute_user_id' => $user->id,
                'institute_code' => substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4)
            ]);
        } catch(Exception $e) {
            $institute_1 = Institute::create([
                'institute_user_id' => $user->id,
                'institute_code' => substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4)
            ]);
        }

        // CourseStudentCount::create([
        //     'institute_id' => $institute_1->institute_id,
        //     'course_id' => $course_1->course_id,
        //     'max_students_in_course_allowed' => 99999
        // ]);

        // CourseStudentCount::create([
        //     'institute_id' => $institute_1->institute_id,
        //     'course_id' => $course_2->course_id,
        //     'max_students_in_course_allowed' => 99999
        // ]);

        // // 2.
        // $user = User::create([
        //     'name' => 'Test Institute 2',
        //     'email' => 'tins2@gmail.com',
        //     'password' => Hash::make('123'),
        //     'contact_no' => '1234567890',
        //     'additional_columns' => 'additional columns',
        //     'address' => 'test address 2',
        //     'city' => 'test city 2',
        //     'email_verified_at' => Carbon::now()
        // ]);
        // $user->assignRole('Institute');
        // $institute_2 = Institute::create([
        //     'institute_user_id' => $user->id,
        // ]);
        // CourseStudentCount::create([
        //     'institute_id' => $institute_2->institute_id,
        //     'course_id' => $course_1->course_id,
        //     'max_students_in_course_allowed' => 30
        // ]);

        // //-------------------------------------------------------------------------------

        // // Student
        // // 1.
        // $user = User::create([
        //     'name' => 'Test Student',
        //     'email' => 'tstud@gmail.com',
        //     'password' => Hash::make('123'),
        //     'contact_no' => '1234567890',
        //     'additional_columns' => 'additional columns',
        //     'address' => 'test address',
        //     'city' => 'test city',
        //     'email_verified_at' => Carbon::now()
        // ]);
        // $user->assignRole('Student');
        // $student_1 = Student::create([
        //     'student_user_id' => $user->id,
        //     'student_account_completion' => 0,
        // ]);

        // // 2.
        // $user = User::create([
        //     'name' => 'Test Student 2',
        //     'email' => 'tstud2@gmail.com',
        //     'password' => Hash::make('123'),
        //     'contact_no' => '1234567890',
        //     'additional_columns' => 'additional columns',
        //     'address' => 'test address 2',
        //     'city' => 'test city 2',
        //     'email_verified_at' => Carbon::now()
        // ]);
        // $user->assignRole('Student');
        // $student_2 = Student::create([
        //     'student_user_id' => $user->id,
        //     'student_account_completion' => 0
        // ]);


        // // Enrollments
        // //1.
        // Enrollment::create([
        //     'student_id' => $student_1->student_id,
        //     'institute_id' => $institute_1->institute_id,
        //     'course_id' => 1,
        //     'enrollment_status' => '0',
        // ]);

        // //2.
        // Enrollment::create([
        //     'student_id' => $student_2->student_id,
        //     'institute_id' => $institute_1->institute_id,
        //     'course_id' => 1,
        //     'enrollment_status' => '0',
        // ]);
    }
}
