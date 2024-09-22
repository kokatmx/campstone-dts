<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $table = 'schedules';
    protected $primaryKey = 'id_schedule'; // Menentukan primary key
    // public $incrementing = false;

    protected $fillable = [
        'id_schedule',
        'id_employee',
        'date',
        'shift',
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'id_employee', 'id_employee');
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'id_schedule');
    }
}
