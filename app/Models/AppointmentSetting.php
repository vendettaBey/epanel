<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentSetting extends Model
{
    use HasFactory;
    protected $fillable = ['day_of_week', 'start_time', 'end_time', 'time_slot'];
}
