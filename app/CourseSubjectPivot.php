<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseSubjectPivot extends Pivot
{
    protected $table = 'course_subject_pivot';

    protected $primaryKey = 'course_subject_pivot_id';

    protected $fillable = [
        'course_id', 'subject_id'
    ];

    public function courses() {
        return $this->hasMany('App\Course', 'course_id', 'course_id');
    }

    public function subjects() {
        return $this->hasMany('App\Subject', 'subject_id', 'subject_id');
    }
}
