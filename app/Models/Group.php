<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;
use App\Models\Student;

class Group extends Model
{
    use HasFactory;
    protected $table = 'groups';
    protected $fillable = [
        'name', 'public' , 'course_id'
    ];
    // The students that belong to the Group
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
    // Get all of the messages for the Group
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
