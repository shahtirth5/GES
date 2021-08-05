<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestSelectedQuestion extends Model
{
    protected $table = 'test_selected_questions';

    protected $primaryKey = 'test_selected_question_id';

    protected $fillable = [
        'test_session_id', 'question_id', 'selected_option_id', 'status', 'timestamps'
    ];

    public function testSession() {
        return $this->belongsTo('App\TestSession', 'test_session_id', 'test_session_id');
    }

    public function question() {
        return $this->belongsTo('App\Question', 'question_id', 'question_id');
    }

    public function selectedOption() {
        return $this->belongsTo('App\Option', 'selected_option_id', 'option_id');
    }
}
