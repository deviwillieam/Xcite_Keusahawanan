<?php

namespace Vanguard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name',
        'group_email',
        'brief_about',
        'video_url',
        'video_file',
        'pitchdeck_file',
        'user_id', // Add user_id to the fillable array
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    // Optional: Define a relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class); // Assuming you have a User model
    }
}
