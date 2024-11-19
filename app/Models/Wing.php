<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Wing
 *
 * @property $id
 * @property $name
 * @property $building_id
 * @property $created_at
 * @property $updated_at
 * @property Building $building
 * @property Room[] $rooms
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Wing extends Model
{
    use HasFactory;
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','building_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function building():BelongsTo
    {
        return $this->belongsTo(Building::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rooms():HasMany
    {
        return $this->hasMany(Room::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function wingSupervisor():HasOne
    {
        return $this->hasOne(WingSupervisor::class);
    }
}
