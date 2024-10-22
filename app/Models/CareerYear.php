<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Career_year
 *
 * @property $id
 * @property $academic_year
 * @property $year
 * @property $career_id
 * @property $created_at
 * @property $updated_at
 * @property Career $career
 * @property Group[] $Groups
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class CareerYear extends Model
{
    use HasFactory;
     /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','year','career_id'];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function career():BelongsTo
    {
        return $this->belongsTo(Career::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function group():HasMany
    {
        return $this->hasMany(Group::class);
    }
}
