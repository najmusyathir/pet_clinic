<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppointmentService extends Model
{
    use HasFactory;
    protected $fillable = [
        'appointment_id',
        'service_id',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function service()
    {
        return $this->belongsTo(Pet::class, 'service_id');
    }

}
