<?php

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    use UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $incrementing = false;
    
    protected $fillable = [
        'id', 'first_name', 'last_name', 'parent_name', 'standard', 'course', 'email'
    ];


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];


    public function student_document() {
        return $this->hasMany('App\StudentDocument', 'student_id', 'id');
    }
}