<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enrollment extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'enrollment_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id', 'institute_id', 'course_id', 'enrollment_status', 'enrollment_verified_at'
    ];

    // Enrollment status values
    // -1 => rejected
    // 0 => no response yet
    // 1 => accepted
    // 2 => accepted and then rejected
    // 3 => blocked

    public function student() {
        $this->belongsTo('App\Student', 'student_id', 'student_id');
    }

    public function institute() {
        $this->belongsTo('App\Institutes', 'institute_id', 'institute_id');
    }

    public function course() {
        $this->belongsTo('App\Courses', 'course_id', 'course_id');
    }
}
