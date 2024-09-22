<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $table = 'leaves';
    protected $primaryKey = 'id_leave';
    public $incrementing = true;
    protected $fillable = [
        'id_leave',
        'id_employee',
        'start_date',
        'end_date',
        'reason',
        'status',
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'id_employee', 'id_employee');
    }
}
