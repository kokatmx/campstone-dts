<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
    protected $table = 'salaries';
    protected $primaryKey = 'id_salary'; // Menentukan primary key
    public $incrementing = false;

    protected $fillable = [
        'id_employee',
        'basic_salary',
        'allowances',
        'deductions',
        'total_salary',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'id_employee', 'id_employee');
    }
    // App\Models\Salary.php

    // public function setTotalSalaryAttribute($value)
    // {
    //     $this->attributes['total_salary'] = $this->basic_salary + $this->allowances - $this->deductions;
    // }
}
