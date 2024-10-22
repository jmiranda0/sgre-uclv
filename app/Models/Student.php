<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'last_name',
        'dni', 
        'scholarship_card', 
        'is_foreign', 
        'country_id', 
        'municipality_id', 
        'group_id', 
        'room_id', 
        
    ];

    public function cleaningSchedules()
    {
        return $this->belongsToMany(CleaningSchedule::class, 'cleaning_schedule_students')
                    ->withPivot('evaluation', 'comments')
                    ->withTimestamps();
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group():BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function municipality():BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country():BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room():BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
    public function getStudentDetailsAttribute()
    {
        return $this->students->map(function ($student) {
            return [
                'name' => $student->name,
                'wing' => $student->room->wing->name ?? 'N/A', // Asegúrate de manejar la relación correctamente
                'room' => $student->room->name ?? 'N/A',
                'building' => $student->room->wing->building->name ?? 'N/A',
            ];
        });
    }
}
