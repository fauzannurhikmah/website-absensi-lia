<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'employee_id', 'position_id'];
    protected $with = ['employee', 'position', 'attendance'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function attendance()
    {
        return $this->hasMany(AttendanceStatus::class, 'presence_id');
    }
}
