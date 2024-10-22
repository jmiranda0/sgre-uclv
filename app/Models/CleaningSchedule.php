<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CleaningSchedule extends Model
{
    use HasFactory;
    protected $fillable = ['cleaning_date'];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'cleaning_schedule_students')
                    ->withPivot('evaluation', 'comments')
                    ->withTimestamps();
    }
}
