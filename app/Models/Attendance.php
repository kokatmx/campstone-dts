<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';
    protected $primaryKey = 'id_attendance'; // Menentukan primary key
    public $incrementing = true; // untuk auto increament id_attendance

    protected $fillable = [
        'id_attendance',
        'id_schedule',
        'id_employee',
        'date',
        'time_in',
        'time_out',
        'status',
        'notes',
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'id_employee', 'id_employee');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'id_schedule');
    }
}
