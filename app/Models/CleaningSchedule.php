<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
    public function scopeVisibleForUser(Builder $query, $user): Builder
    {
        if ($user->hasRole('Wing_Supervisor')) {
            // Acceder a los wings supervisados por este usuario
            return $query->whereHas('students', function (Builder $studentQuery) use ($user) {
                $studentQuery->whereHas('room', function (Builder $roomQuery) use ($user) {
                    $roomQuery->whereHas('wing', function (Builder $wingQuery) use ($user) {
                        $wingQuery->whereHas('wingSupervisor', function (Builder $wingSupervisorQuery) use ($user) {
                            $wingSupervisorQuery->whereHas('professor', function (Builder $professorQuery) use ($user) {
                                $professorQuery->where('user_id', $user->id);
                            });
                        });
                    });
                });
            });
        }
        
        if ($user->hasRole('Student')) {
            
            return $query->whereHas('students', function (Builder $studentQuery) use ($user){
                            $studentQuery->where('student_id',$user->student->id);
            });
        }
        
        // Residence_Manager puede ver todos los cuartos
        return $query;
        
    }
}
