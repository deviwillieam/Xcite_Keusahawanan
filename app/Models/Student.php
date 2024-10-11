<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'student_name',
        'student_email',
        'phone_number',
        'course',
        'year_course',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
