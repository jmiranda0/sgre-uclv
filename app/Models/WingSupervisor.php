<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WingSupervisor extends Model
{
    use HasFactory;

    /**
    * Attributes that should be mass-assignable.
    *
    * @var array
    */
    protected $fillable = ['professor_id','wing_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function professor():BelongsTo
    {
        return $this->belongsTo(Professor::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wing():BelongsTo
    {
        return $this->belongsTo(Wing::class);
    }
}
