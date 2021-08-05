<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    /**
     * The attributes that specifies name of the table in database.
     *
     * @var string
     */
    protected $table = 'tests';

    /**
     * The attribute that specifies primary key of the table in database.
     *
     * @var string
     */
    protected $primaryKey = 'test_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'test_name', 'test_description', 'course_id', 'test_start_time', 'test_end_time', 'test_duration', 'institute_id', 'positive_marking', 'neutral_marking', 'negative_marking'
    ];

    public function institute() {
        return $this->belongsTo('App\Institute', 'institute_id', 'institute_id');
    }

    public function course() {
        return $this->belongsTo('App\Course', 'course_id', 'course_id');
    }



    public function questions() {
        return $this->belongsToMany('App\Question', 'App\TestQuestionPivot', 'test_id', 'question_id');
    }

}
