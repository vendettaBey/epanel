<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    protected $casts = [
        'work_days' => 'array',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

}
