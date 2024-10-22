<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Class Building
 *
 * @property $id
 * @property $name
 * @property $campus
 * @property $created_at
 * @property $updated_at
 * @property Wing[] $wings
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Building extends Model
{
    use HasFactory;
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','campus'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wings()
    {
        return $this->hasMany(Wing::class);
    }
}
