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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function faculty():HasOne
    {
        return $this->hasOne(Faculty::class);
    }
    protected static function booted()
    {   
            if (request()->has('professor')) {
                // Crear el profesor antes de guardar el decano
                dd(request());
                $professor = Professor::create([
                    'name' => request('professor.name'),
                    'dni' => request('professor.dni'),
                ]);
                $professor->save();
                // Asignar el ID del profesor al decano
                $professor_id = $professor->id;
                return $professor_id;
            }
    }
}
