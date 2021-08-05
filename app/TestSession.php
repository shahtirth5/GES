<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestSession extends Model
{
    // test_session_id, test_id, student_id, session_timer, session_status
    protected $table = 'test_sessions';

    protected $primaryKey = 'test_session_id';

    protected $fillable = [
        'test_id', 'student_id', 'session_timer', 'session_status'
    ];

    public function test() {
        return $this->belongsTo('App\Test', 'test_id', 'test_id');
    }

    public function student() {
        return $this->belongsTo('App\Student', 'student_id', 'student_id');
    }
}
