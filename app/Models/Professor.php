<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasOne;

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
    protected $fillable = [
                            'name',
                            'dni',
                            'user_id',
                        ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dean():HasOne
    {
        return $this->hasOne(Dean::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function yearLeadProfessor():HasOne
    {
        return $this->hasOne(YearLeadProfessor::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function wingSupervisor():HasOne
    {
        return $this->hasOne(WingSupervisor::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function groupAdvisor():HasOne
    {
        return $this->hasOne(GroupAdvisor::class);
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
}
