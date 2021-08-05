<?php
namespace App\Services;

use DB;
use App\Course;
use App\CourseSubjectPivot;
use App\CourseStudentCount;

class CourseService {
    public function addCourse($course_name , $course_description , $subject_id , $institute_id) {
        $course = Course::create([
            'course_name' => $course_name,
            'course_description' => $course_description,
        ]);
        $course_id = $course->course_id;

        //Course subject pivot table
        for($i = 0 ; $i < sizeof($subject_id) ; $i++) {
            $course_subject_pivot = CourseSubjectPivot::create([
                'course_id' => $course_id,
                'subject_id' => $subject_id[$i],
            ]);
        }

        //Course Student Count
        for($i = 0 ; $i < sizeof($institute_id) ; $i++)
        {
            $course_student_count = CourseStudentCount::create([
                'institute_id' => $institute_id[$i],
                'course_id' => $course_id,
                'max_students_in_course_allowed' => 30,
            ]);
        }
    }

    public function getCourses($columns) {
        $result = Course::all($columns);
        return $result;
    }

    public function deleteCourse($course_id , $complete_delete) {
        if ($complete_delete) {
            CourseStudentCount::where('course_id', $course_id)->delete();
            CourseSubjectPivot::where('course_id', $course_id)->delete();
            Course::find($course_id)->delete();
        }
        else{
            CourseStudentCount::where('course_id', $course_id)->delete();
            CourseSubjectPivot::where('course_id', $course_id)->delete();
        }
    }

    public function editCourse($course_id , $course_name , $course_description , $subject_id , $institute_id)
    {
        //Course subject pivot table
        for($i = 0 ; $i < sizeof($subject_id) ; $i++) {
            $course_subject_pivot = CourseSubjectPivot::create([
                'course_id' => $course_id,
                'subject_id' => $subject_id[$i],
            ]);
        }

        //Course Student Count
        for($i = 0 ; $i < sizeof($institute_id) ; $i++)
        {
            $course_student_count = CourseStudentCount::create([
                'institute_id' => $institute_id[$i],
                'course_id' => $course_id,
                'max_students_in_course_allowed' => 30,
            ]);
        }

        Course::where('course_id', '=', $course_id)->update(['course_name'=>$course_name, 'course_description'=> $course_description]);
    }
}
