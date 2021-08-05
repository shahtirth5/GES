<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $primaryKey = 'course_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_name', 'course_description'
    ];

    public function enrollments() {
        return $this->hasMany('App\Enrollment');
    }

    public function subjects() {
        return $this->belongsToMany('App\Subject', 'App\CourseSubjectPivot', 'course_id','subject_id');
    }
}
