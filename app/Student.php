<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;
    /**
     * The attributes that specifies name of the table in database.
     *
     * @var string
     */
    protected $table = 'students';

    /**
     * The attribute that specifies primary key of the table in database.
     *
     * @var string
     */
    protected $primaryKey = 'student_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_user_id', 'student_account_completion'
    ];

    public function user() {
        return $this->belongsTo('App\User', 'student_user_id', 'id');
    }
}
