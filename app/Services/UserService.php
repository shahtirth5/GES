<?php


namespace App\Services;


use App\Institute;
use App\Student;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    // The function below gives the student id from the auth (user) id
    public static function getAuthStudentId() {
        $student_id = Student::where('student_user_id', '=', Auth::id())->first()->student_id;
        return $student_id;
    }

    // The function below gives the institute id from the auth (user) id
    public static function getAuthInstituteId() {
        $institute_id = Institute::where('institute_user_id', '=', Auth::id())->first()->institute_id;
        return $institute_id;
    }

    public static function getUserDetailsFromInstituteOrStudentId($id) {
        $isStudent = false;
        $student = null;
        $institute = null;
        $student = Student::where('student_id'. '=', $id)->first();
        if($student != null) {
            $user_id = $student->student_user_id;
            return User::where('id', '=', $user_id);
        }

        $institute = Institute::where('institute_id', '=', $id)->first();
        $user_id = $institute->institute_user_id;
        return User::where('id', '=', $user_id);
    }
}
