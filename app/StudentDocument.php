<?php 

namespace App;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class StudentDocument extends Model
{
    use UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $incrementing = false;

    protected $fillable = [
        'id', 'student_id', 'file_name', 'file_extension', 'doc_type', 'file', 'mime_type',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

}