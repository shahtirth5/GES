<?php

namespace App\Services;

use App\Enrollment;
use App\Institute;
use App\Student;
use App\User;

class StudentService {
    public function getUserStudentAndEnrollmentInfo() {
        $student_id = UserService::getAuthStudentId();
        $query = Enrollment::where('student_id', '=', $student_id)->orderByDesc('updated_at')->first();
        return $query;
    }

    public function isAccountCompleted() {
        $student_id = UserService::getAuthStudentId();
        $isAccountCompleted = Student::where('student_id', '=', $student_id)->first()->student_account_completion;
        if($isAccountCompleted == 0) {
            return false;
        }
        return true;
    }

    public function getEnrolledInstituteUserDetails() {
        $student_id = UserService::getAuthStudentId();
        $enrollment = Enrollment::where('student_id', '=', $student_id)->where('enrollment_status', '=', '1')->first();
        if($enrollment != null) {
            $institute_user_id = Institute::where('institute_id', '=', $enrollment->institute_id)->first()->institute_user_id;
            $user = User::where('id', '=', $institute_user_id)->first(['name']);
            return $user;
        } else {
            return null;
        }
    }
}

