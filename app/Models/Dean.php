<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Dean extends Model
{
    use HasFactory;

    /**
    * Attributes that should be mass-assignable.
    *
    * @var array
    */
    protected $fillable = ['professor_id','faculty_id'];


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
    public function faculty():BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }
    
}
