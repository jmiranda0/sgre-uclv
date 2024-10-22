<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Municipality
 *
 * @property $id
 * @property $name
 * @property $province_id
 * @property $created_at
 * @property $updated_at
 * @property Province $province
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Municipality extends Model
{
    use HasFactory;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','province_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province():BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
}
