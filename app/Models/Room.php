<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Room
 *
 * @property $id
 * @property $name
 * @property $wings_id
 * @property $created_at
 * @property $updated_at
 * @property Basicmedia[] $basicmedia
 * @property RoomsEvaluation[] $roomsEvaluations
 * @property Student[] $students
 * @property Wing $wing
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Room extends Model
{
    use HasFactory;
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'room_capacity',
        'students_amount',
        'is_available',
        'wings_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wing():BelongsTo
    {
        return $this->belongsTo(Wing::class);
    }
}
