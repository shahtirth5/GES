<?php
namespace App\Services;

use DB;
use App\Subject;
use App\CourseSubjectPivot;

class SubjectService {

    public function getAllSubjects($columns) {
        return Subject::all($columns);
    }

    public function getSubjects($institute_id) {
        $subjects = DB::table('course_student_counts')
            ->rightJoin('course_subject_pivot', 'course_subject_pivot.course_id','=', 'course_student_counts.course_id')
            ->rightJoin('subjects', 'subjects.subject_id', '=', 'course_subject_pivot.subject_id')
            ->where('course_student_counts.institute_id', '=', $institute_id)
            ->distinct('subjects.subject_id')
            ->get(['subjects.subject_id', 'subjects.subject_name', 'subjects.subject_description']);
        return $subjects;
    }

    public function addSubject($subject_name , $subject_description) {
        Subject::create([
            'subject_name' => $subject_name,
            'subject_description' => $subject_description,
        ]);
    }

    public function getSubjectById($subject_id, $columns) {
        $result = Subject::where('subject_id' , $request->subject_id)->get($columns)->first();
        return $result;
    }

    public function deleteSubject($subject_id){
        CourseSubjectPivot::where('subject_id' , $subject_id)->delete();
        Subject::where('subject_id' , $subject_id)->delete();
    }

    public function editSubject($subject_id, $columns) {
        Subject::where('subject_id' , $subject_id)->update($columns);
    }
}
