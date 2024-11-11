<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Professor
 *
 * @property $id
 * @property $name
 * @property $dni
 * @property $created_at
 * @property $updated_at
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Professor extends Model
{
    use HasFactory;
     /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','dni'];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deans():HasMany
    {
        return $this->hasMany(Dean::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function yearLeadProfessors():HasMany
    {
        return $this->hasMany(YearLeadProfessor::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wingSupervisors():HasMany
    {
        return $this->hasMany(WingSupervisor::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groupAdvisors():HasMany
    {
        return $this->hasMany(GroupAdvisor::class);
    }
    
}
