<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class YearLeadProfessor extends Model
{
    use HasFactory;

    /**
    * Attributes that should be mass-assignable.
    *
    * @var array
    */
    protected $fillable = ['professor_id','career_year_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function professor():BelongsTo
    {
        return $this->belongsTo(Professor::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function careerYear():BelongsTo
    {
        return $this->belongsTo(CareerYear::class);
    }

    public function scopeVisibleForUser(Builder $query, $user): Builder
    {
        if ($user->hasRole('Faculty_Dean')) {
            // Acceder a los wings supervisados por este usuario
            return $query->whereHas('careeryear', function (Builder $careeryearQuery) use ($user) {
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
           
        }
        
    
        
        // Residence_Manager puede ver todos los cuartos
        return $query;
        
    }
}
