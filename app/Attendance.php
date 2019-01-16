<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances';

    protected $fillable = ['user_id', 'time_in', 'time_out', 'day'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'user_id');
    }
}
