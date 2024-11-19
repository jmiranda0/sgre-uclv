<?php

namespace App\Models;

use App\Enums\ComplaintStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'theme',        // Tema de la queja
        'text',         // Descripción de la queja
        'status',       // Estado de la queja (pendiente, revisada, resuelta)
        'student_id',   // ID del estudiante que realiza la queja
    ];

    protected $casts = [
        'status' => ComplaintStatusEnum::class,  // Cast para el campo 'status' usando el enum
    ];

    /**
     * Relación con el estudiante que hizo la queja
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Cambiar el estado de la queja
     *
     * @param  ComplaintStatusEnum  $status
     * @return void
     */
    public function changeStatus(ComplaintStatusEnum $status): void
    {
        $this->update(['status' => $status]);
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
            return $query->whereHas('student', function (Builder $studentQuery) use ($user){
                            $studentQuery->where('student_id',$user->student->id);
            });
        }
        
        // Residence_Manager puede ver todos los cuartos
        return $query;
        
    }
}
