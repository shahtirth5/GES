<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';

    protected $primaryKey = 'subject_id';

    protected $fillable = [
      'subject_name', 'subject_description'
    ];

    public function courses() {
        return $this->belongsToMany('App\Course', 'App\CourseSubjectPivot', 'subject_id','course_id');
    }

    public function chapters() {
        return $this->hasMany('App\Chapter', 'subject_id', 'subject_id');
    }
}
