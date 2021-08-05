<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseStudentCount extends Model
{
    protected $table = 'course_student_counts';
    protected $primaryKey = 'course_student_count_id';

    protected $fillable = [
        'institute_id', 'course_id', 'max_students_in_course_allowed'
    ];
}
