<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Faculty
 *
 * @property $id
 * @property $name
 * @property $created_at
 * @property $updated_at
 * @property Career[] $careers
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Faculty extends Model
{
    use HasFactory;
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function careers():HasMany
    {
        return $this->hasMany(Career::class);
    }
    
}
