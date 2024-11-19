<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Group
 *
 * @property $id
 * @property $group_number
 * @property $career_year_id
 * @property $created_at
 * @property $updated_at
 * @property CareerYear $careeryear
 * @property Student[] $students
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Group extends Model
{
    use HasFactory;
     /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['group_number','career_year_id'];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function careerYear():BelongsTo
    {
        return $this->belongsTo(CareerYear::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students():HasMany
    {
        return $this->hasMany(Student::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function GroupAdvisor():HasOne
    {
        return $this->hasOne(GroupAdvisor::class);
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
        if ($user->hasRole('Year_Lead_Professor')) {
            // Acceder a los wings supervisados por este usuario
            return $query->whereHas('careeryear', function (Builder $careeryearQuery) use ($user) {
                        $careeryearQuery->whereHas('yearleadprofessor', function (Builder $yearleadprofessorQuery) use ($user) {
                                    $yearleadprofessorQuery->whereHas('professor', function (Builder $professorQuery) use ($user) {
                                        $professorQuery->where('user_id', $user->id);
                                    });
                        });
                    });
        }

        return $query;
        
    }


}
