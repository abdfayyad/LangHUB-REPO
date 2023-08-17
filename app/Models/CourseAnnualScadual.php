<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAnnualScadual extends Model
{
    use HasFactory;
    protected $table = 'course_annual_scaduals';
    protected $fillable = [
        'saturday', 'start_saturday', 'end_saturday',
        'sunday', 'start_sunday', 'end_sunday',
        'monday', 'start_monday', 'end_monday',
        'tuesday', 'start_tuesday', 'end_tuesday',
        'wednsday', 'start_wednsday', 'end_wednsday',
        'thursday', 'start_thursday', 'end_thursday',
        'friday', 'start_friday', 'end_friday',
        'course_id'
    ];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
