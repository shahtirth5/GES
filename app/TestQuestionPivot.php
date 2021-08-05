<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestQuestionPivot extends Model
{
    protected $table = 'test_question_pivot';

    protected $primaryKey = 'test_question_pivot_id';

    protected $fillable = [
        'test_id', 'question_id'
    ];

    public function questions() {
        return $this->hasMany('App\Question', 'question_id', 'question_id');
    }

    public function tests() {
        return $this->hasMany('App\Test', 'test_id', 'test_id');
    }
}
