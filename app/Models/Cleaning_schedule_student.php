<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cleaning_schedule_student extends Model
{
    use HasFactory;
    protected $fillable = [
        'cleaning_schedule_id',
        'student_id',
        'evaluation',
        'comments',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function cleaningSchedule()
    {
        return $this->belongsTo(CleaningSchedule::class);
    }
}
