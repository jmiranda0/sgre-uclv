<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Province
 *
 * @property $id
 * @property $name
 * @property $created_at
 * @property $updated_at
 * @property Municipality[] $municipalities
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Province extends Model
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
    public function municipalities():HasMany
    {
        return $this->hasMany(Municipality::class);
    }
}
