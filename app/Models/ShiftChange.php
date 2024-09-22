<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftChange extends Model
{
    use HasFactory;
    protected $tabel = 'shift_changes';
    protected $primaryKey = 'id_shift_changes';
    protected $fillable = ['id_schedule_from', 'id_schedule_to', 'status'];

    public function scheduleFrom()
    {
        return $this->belongsTo(Schedule::class, 'id_schedule_from');
    }

    public function scheduleTo()
    {
        return $this->belongsTo(Schedule::class, 'id_schedule_to');
    }
}
