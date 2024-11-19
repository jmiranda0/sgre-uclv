<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Career
 *
 * @property $id
 * @property $name
 * @property $facultie_id
 * @property $created_at
 * @property $updated_at
 * @property Faculty $faculty
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Career extends Model
{
    use HasFactory;
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','faculty_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function faculty():BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    public function scopeVisibleForUser(Builder $query, $user): Builder
    {
        if ($user->hasRole('Faculty_Dean')) {
            // Acceder a los wings supervisados por este usuario
            return $query->whereHas('faculty', function (Builder $facultyQuery) use ($user) {
                        $facultyQuery->whereHas('dean', function (Builder $deanyQuery) use ($user){
                            $deanyQuery->whereHas('professor', function (Builder $professorQuery) use ($user) {
                                $professorQuery->where('user_id', $user->id);
                            });
                        });
                    });
        }
        
    
        
        // Residence_Manager puede ver todos los cuartos
        return $query;
        
    }

}
