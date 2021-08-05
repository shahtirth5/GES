<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $primaryKey = 'question_id';

    protected $table = 'questions';

    protected $fillable = [
        'question_text', 'question_answer_explanation', 'institute_id', 'subject_id', 'chapter_id', 'question_rating', 'institute_id'
    ];

    public function institute() {
        return $this->belongsTo('App\Institute', 'institute_id', 'institute_id');
    }

    public function subject() {
        return $this->belongsTo('App\Subject', 'subject_id', 'subject_id');
    }

    public function chapter() {
        return $this->belongsTo('App\Chapter', 'chapter_id', 'chapter_id');
    }

    public function options() {
        return $this->hasMany('App\Option', 'question_id', 'question_id');
    }

    public function tests() {
        return $this->belongsToMany('App\Test', 'App\TestQuestionPivot', 'question_id', 'test_id');
    }
}
