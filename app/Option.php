<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'options';

    protected $primaryKey = 'option_id';

    protected $fillable = [
        'option_text', 'is_correct', 'question_id'
    ];

    public function question() {
        return $this->belongsTo('App\Question', 'question_id', 'question_id');
    }
}
