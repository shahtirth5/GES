<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $table = 'test_results';

    protected $primaryKey = 'test_result_id';

    protected $fillable = [
        'test_id', 'student_id' , 'marks_scored' , 'max_marks'
    ];

    public function test() {
        return $this->belongsTo('App\Test', 'test_id', 'test_id');
    }

    public function student() {
        return $this->belongsTo('App\Student', 'student_id', 'student_id');
    }
}
