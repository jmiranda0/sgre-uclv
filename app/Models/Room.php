<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Room
 *
 * @property $id
 * @property $name
 * @property $wings_id
 * @property $created_at
 * @property $updated_at
 * @property Basicmedia[] $basicmedia
 * @property RoomsEvaluation[] $roomsEvaluations
 * @property Student[] $students
 * @property Wing $wing
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Room extends Model
{
    use HasFactory;
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'room_capacity',
        'students_amount',
        'is_available',
        'wing_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wing():BelongsTo
    {
        return $this->belongsTo(Wing::class);
    }
    /**
     * 
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function scopeVisibleForUser(Builder $query, $user): Builder
    {
        if ($user->hasRole('Wing_Supervisor')) {
            // Acceder a los wings supervisados por este usuario
            return $query->whereHas('wing', function (Builder $wingQuery) use ($user) {
                $wingQuery->whereHas('wingSupervisor', function (Builder $supervisorQuery) use ($user) {
                    $supervisorQuery->whereHas('professor', function (Builder $professorQuery) use ($user) {
                        $professorQuery->where('user_id', $user->id);
                    });
                });
            });
        }
    
        return $query;
        
    }
}
