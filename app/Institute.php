<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{

    /**
     * The attributes that specifies name of the table in database.
     *
     * @var string
     */
    protected $table = 'institutes';

    /**
     * The attribute that specifies primary key of the table in database.
     *
     * @var string
     */
    protected $primaryKey = 'institute_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'institute_user_id', 'institute_code'
    ];

    public function user() {
        return $this->belongsTo("App\User","institute_user_id", 'id');
    }

    public function students() {
        return $this->hasMany("App\Student");
    }

}
