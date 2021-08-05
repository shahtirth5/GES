<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $table = 'chapters';

    protected $primaryKey = 'chapter_id';

    protected $fillable = [
        'chapter_name', 'chapter_description', 'subject_id'
    ];

    public function subject() {
        return $this->belongsTo('App\Subject', 'subject_id', 'subject_id');
    }
}
