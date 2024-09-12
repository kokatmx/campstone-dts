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
        'name',
        'email',
        'address',
        'gender',
        'no_hp',
        'id_position',
        'id_department',
    ];
    public function position()
    {
        return $this->belongsTo(Position::class, 'id_position');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'id_department');
    }
    public function salary()
    {
        return $this->hasMany(Salary::class);
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }

    public function leave()
    {
        return $this->hasMany(Leave::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
}
