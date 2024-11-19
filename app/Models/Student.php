<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'last_name',
        'dni', 
        'scholarship_card', 
        'is_foreign', 
        'country_id', 
        'municipality_id', 
        'group_id', 
        'room_id', 
        'user_id', 
        
    ];

    public function cleaningSchedules()
    {
        return $this->belongsToMany(CleaningSchedule::class, 'cleaning_schedule_students')
                    ->withPivot('evaluation', 'comments')
                    ->withTimestamps();
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group():BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function municipality():BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country():BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room():BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
    
    /**
     *  Relación con las quejas (un estudiante puede tener varias quejas)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
    /**
     * Relación inversa con el modelo User
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    

    public function scopeVisibleForUser(Builder $query, $user): Builder
    {
        if ($user->hasRole('Wing_Supervisor')) {
            // Acceder a los wings supervisados por este usuario
            return $query->whereHas('room', function (Builder $roomQuery) use ($user) {
                    $roomQuery->whereHas('wing', function (Builder $wingQuery) use ($user) {
                        $wingQuery->whereHas('wingSupervisor', function (Builder $wingSupervisorQuery) use ($user) {
                            $wingSupervisorQuery->whereHas('professor', function (Builder $professorQuery) use ($user) {
                                $professorQuery->where('user_id', $user->id);
                            });
                        });
                    });
            });
        }
        if ($user->hasRole('Faculty_Dean')) {
            // Acceder a los wings supervisados por este usuario
            return $query->whereHas('group', function (Builder $groupQuery) use ($user) {
                    $groupQuery->whereHas('careeryear', function (Builder $careeryearQuery) use ($user) {
                        $careeryearQuery->whereHas('career', function (Builder $careerQuery) use ($user) {
                            $careerQuery->whereHas('faculty', function (Builder $facultyQuery) use ($user) {
                                $facultyQuery->whereHas('dean', function (Builder $deanyQuery) use ($user){
                                    $deanyQuery->whereHas('professor', function (Builder $professorQuery) use ($user) {
                                        $professorQuery->where('user_id', $user->id);
                                    });
                                });
                            });
                        });
                    });
            });
        }
        if ($user->hasRole('Year_Lead_Professor')) {
            // Acceder a los wings supervisados por este usuario
            return $query->whereHas('group', function (Builder $groupQuery) use ($user) {
                        $groupQuery->whereHas('careeryear', function (Builder $careeryearQuery) use ($user) {
                                $careeryearQuery->whereHas('yearleadprofessor', function (Builder $yearleadprofessorQuery) use ($user) {
                                    $yearleadprofessorQuery->whereHas('professor', function (Builder $professorQuery) use ($user) {
                                        $professorQuery->where('user_id', $user->id);
                                    });
                                });
                            });
                        });
        }
        if ($user->hasRole('Group_Advisor')) {
            // Acceder a los wings supervisados por este usuario
            return $query->whereHas('group', function (Builder $groupQuery) use ($user) {
                        $groupQuery->whereHas('groupadvisor', function (Builder $groupadvisorQuery) use ($user) {
                            $groupadvisorQuery->whereHas('professor', function (Builder $professorQuery) use ($user) {
                                $professorQuery->where('user_id', $user->id);
                                });
                            });
                        });
        }
    
        // Residence_Manager puede ver todos los cuartos
        return $query;
        
    }
    protected static function booted()
    {
        // Cuando un estudiante se crea o se actualiza (incluso al cambiar de cuarto)
        static::saved(function ($student) {
            // Obtener el cuarto del estudiante
            $room = $student->room;
            
            if ($room) {
                // Comprobar el número de estudiantes en el cuarto
                $studentsCount = $room->students()->count();

                // Si la cantidad de estudiantes es igual o mayor que la capacidad máxima, marcar como no disponible
                $room->is_available = $studentsCount >= $room->room_capacity ? false : true;

                // Guardar el estado actualizado
                $room->save();
            }
        });

        // Cuando un estudiante es eliminado
        static::deleted(function ($student) {
            // Obtener el cuarto del estudiante eliminado
            $room = $student->room;

            if ($room) {
                // Comprobar el número de estudiantes en el cuarto
                $studentsCount = $room->students()->count();

                // Si la cantidad de estudiantes es menor que la capacidad máxima, marcar como disponible
                $room->is_available = $studentsCount < $room->room_capacity;

                // Guardar el estado actualizado
                $room->save();
            }
        });
    }

    
}
