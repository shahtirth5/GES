<?php


namespace App\Services;


use App\Chapter;
use App\Course;
use App\CourseStudentCount;
use App\CourseSubjectPivot;
use App\Subject;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Promise\all;

class AdminServices
{
    public function addCourse($course_name , $course_description , $subject_id , $institute_id)
    {

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

    public function getCoursesRequests(){
        $result = DB::table('courses')->get(['course_id' , 'course_name' , 'course_description']);
        return $result;
    }

    public function deleteCourse($course_id , $complete_delete)
    {
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
    }

    public function addSubject($subject_name , $subject_description)
    {
        Subject::create([
            'subject_name' => $subject_name,
            'subject_description' => $subject_description,
        ]);
    }

    public function getSubjectsRequest()
    {
        $result = DB::table('subjects')->get(['subject_id' , 'subject_name' , 'subject_description']);
        return $result;
    }

    public function deleteSubject($subject_id){
        CourseSubjectPivot::where('subject_id' , $subject_id)->delete();
        Subject::where('subject_id' , $subject_id)->delete();
    }

    public function addChapter($chapter_name , $chapter_description , $subject_id)
    {
        Chapter::create([
            'chapter_name' => $chapter_name,
            'chapter_description' => $chapter_description,
            'subject_id' => $subject_id,
        ]);
    }

    public function getChaptersRequest()
    {
        $result = DB::table('chapters')->select('chapter_id' , 'chapter_name' , 'chapter_description')->get();
        return $result;
    }
}
