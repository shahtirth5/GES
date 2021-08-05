<?php


namespace App\Services;

use App\CourseStudentCount;
use App\Enrollment;
use App\Student;
use App\User;
use Illuminate\Support\Facades\DB;
use Exception;

class EnrollmentService
{
    // The function checks whether more students could be enrolled or not
    public function canEnroll($institute_id, $course_id) {
        $allowed_count = CourseStudentCount::where('institute_id', '=', $institute_id)->where('course_id', '=', $course_id)->first()->max_students_in_course_allowed;

        $enrollment_count =  Enrollment::where('institute_id', '=', $institute_id)->where('course_id', '=', $course_id)->where('enrollment_status', '=', '1')->get()->count();

        if($enrollment_count < $allowed_count) {
            return true;
        }
        return false;
    }

    // The function below gets the enrollment requests
    public function getEnrollmentRequests($institute_id, $selectionColumns) {
        $result = DB::table('users')
            ->rightJoin('students', 'users.id', '=', 'students.student_user_id')
            ->leftJoin('enrollments', 'students.student_id', '=', 'enrollments.student_id')
            ->leftJoin('courses', 'enrollments.course_id', '=', 'courses.course_id')
            ->where('enrollments.enrollment_status', '=', '0')
            ->where('enrollments.institute_id', '=', $institute_id)
            ->get($selectionColumns);
//            ->get(['users.id', 'students.student_id', 'name', 'address', 'city', 'email', 'contact_no', 'courses.course_id', 'course_name']);
        return $result;
    }

    // The function below gets the existing enrollments
    public function getExistingEnrollments($institute_id, $selectionColumns) {
        $result = DB::table('users')
            ->rightJoin('students', 'users.id', '=', 'students.student_user_id')
            ->leftJoin('enrollments', 'students.student_id', '=', 'enrollments.student_id')
            ->leftJoin('courses', 'enrollments.course_id', '=', 'courses.course_id')
            ->where('enrollments.enrollment_status', '=', '1')
            ->where('enrollments.institute_id', '=', $institute_id)
            ->get($selectionColumns);
//            ->get(['users.id', 'students.student_id', 'name', 'address', 'city', 'email', 'contact_no', 'courses.course_id', 'course_name']);
        return $result;
    }


    // The function below gets the blocked enrollments
    public function getBlockedEnrollments($institute_id, $selectionColumns) {
        $result = DB::table('users')
            ->rightJoin('students', 'users.id', '=', 'students.student_user_id')
            ->leftJoin('enrollments', 'students.student_id', '=', 'enrollments.student_id')
            ->leftJoin('courses', 'enrollments.course_id', '=', 'courses.course_id')
            ->where('enrollments.enrollment_status', '=', '3')
            ->where('enrollments.institute_id', '=', $institute_id)
            ->get($selectionColumns);
//            ->get(['users.id', 'students.student_id', 'name', 'address', 'city', 'email', 'contact_no', 'courses.course_id', 'course_name']);
        return $result;
    }

    // The function below enrolls the student to the course, provided that the institute has required seats
    public function enroll($institute_id, $student_id, $course_id) {
        if(!$this->canEnroll($institute_id, $course_id)) {
            return false;
        }
        try {
            $enrollment = Enrollment::where('institute_id', '=', $institute_id)
                            ->where('student_id', '=', $student_id)
                            ->where('course_id', '=', $course_id)
                            ->first();
            $enrollment->enrollment_status = '1';
            $enrollment->enrollment_verified_at = DB::raw('now()');
            $enrollment->save();

            $student = Student::where('student_id', '=', $student_id)->first();
            $user = User::where('id', '=', $student->student_user_id)->first();
            if($user->email_verified_at != null) {
                $student->student_account_completion = 1;
                $student->save();
            }
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    // The function below changes the enrollment status
    public function changeEnrollmentStatus($institute_id, $student_id, $course_id, $status) {
        try {
            $enrollment = Enrollment::where('institute_id', '=', $institute_id)
                ->where('student_id', '=', $student_id)
                ->where('course_id', '=', $course_id)
                ->first();
            $enrollment->enrollment_status = $status;
            $enrollment->enrollment_verified_at = DB::raw('now()');
            $enrollment->save();

            if($status == '-1' || $status == '2' || $status == '3') {
                $student = Student::where("student_id", "=", $student_id)->first();
                $student->student_account_completion = 0;
                $student->save();
            }
        } catch(Exception $e) {
            return false;
        }
        return true;
    }

    // The function below makes enrollment requests checking whether the enrollment for that course is blocked or not
    public function makeEnrollmentRequest($institute_id, $student_id, $course_id) {
        $enrollment = Enrollment::where('institute_id', '=', $institute_id)
            ->where('student_id', '=', $student_id)
            ->where('course_id', '=', $course_id)
            ->first();

        if($enrollment == null) {
            $new_enrollment = Enrollment::create([
                'student_id' => $student_id,
                'institute_id' => $institute_id,
                'course_id' => $course_id,
                'enrollment_status' => '0',
            ]);
            if($new_enrollment) {
                return true;
            } else {
                throw new Exception(); // Error Creating Record in database
            }
        } else {
            if($enrollment->enrollment_status == 3) {
                return false;
            } else {
                $enrollment->enrollment_status = '0';
                $enrollment_updated = $enrollment->save();
                if($enrollment_updated) {
                    return true;
                } else {
                    throw new Exception();
                }
            }
        }
    }

    // The function below checks the enrollment of a student to an institute
    public function checkEnrollment($student_id, $institute_id) {
       $enrollment = Enrollment::where('student_id', '=', $student_id)
                    ->where('institute_id', '=', $institute_id)
                    ->where('enrollment_status', '=', '1')
                    ->first();
       if($enrollment != null) {
           return true;
       }
       return false;
    }

}
