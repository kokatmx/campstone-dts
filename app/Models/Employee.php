<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employees';
    protected $primaryKey = 'id_employee';
    protected $fillable = [
        'address',
        'gender',
        'no_hp',
        'id_position',
        'id_department',
        'id_user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
    public function position()
    {
        return $this->belongsTo(Position::class, 'id_position', 'id_position');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'id_department');
    }
    public function salary()
    {
        return $this->hasMany(Salary::class, 'id_salary',  'id_salary');
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class, 'id_schedule');
    }

    public function leave()
    {
        return $this->hasMany(Leave::class, 'id_leave');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'id_employee', 'id_employee');
    }
}
